<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            Log::info('Iniciando proceso de registro...');
            
            // Crear el usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'is_verified' => false
            ]);

            Log::info('Usuario creado con ID: '.$user->id);

            // Generar y guardar código de verificación
            $code = $user->getCodeVerification();
            Log::info('Código generado para '.$user->email.': '.$code);
            
            // Enviar email de verificación
            Mail::to($user->email)->send(new VerificationMail($user, $code));
            Log::info('Email de verificación enviado a: '.$user->email);

            // Guardar datos en sesión
            $request->session()->put([
                'verification_user_id' => $user->id,
                'verification_email' => $user->email,
                'verification_attempts' => 0
            ]);

            Log::info('Datos de sesión establecidos para verificación');

            // Redirigir a página de verificación
            return redirect()->route('verification.code');

        } catch (\Exception $e) {
            Log::error('Error en el registro: '.$e->getMessage());
            return back()
                   ->with('error', 'Ocurrió un error durante el registro. Por favor intenta nuevamente.')
                   ->withInput();
        }
    }

    public function codeVerification(Request $request)
    {
        // Verificar si hay un email en sesión
        if (!$request->session()->has('verification_email')) {
            Log::warning('Intento de acceso directo a verificación sin sesión');
            return redirect()->route('register')
                   ->with('error', 'Por favor completa el registro primero.');
        }

        // Verificar intentos máximos (3 intentos)
        $attempts = $request->session()->get('verification_attempts', 0);
        if ($attempts >= 3) {
            $request->session()->forget(['verification_email', 'verification_attempts']);
            Log::warning('Demasiados intentos fallidos para: '.$request->session()->get('verification_email'));
            return redirect()->route('register')
                   ->with('error', 'Demasiados intentos fallidos. Por favor regístrate nuevamente.');
        }

        return view('verification.code', [
            'email' => $request->session()->get('verification_email'),
            'attempts_remaining' => 3 - $attempts
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6|numeric'
        ]);

        // Obtener datos de sesión
        $email = $request->session()->get('verification_email');
        $userId = $request->session()->get('verification_user_id');
        $attempts = $request->session()->get('verification_attempts', 0);

        // Incrementar intentos
        $request->session()->put('verification_attempts', $attempts + 1);
        Log::info("Intento de verificación #".($attempts+1)." para $email");

        // Buscar usuario
        $user = User::where('id', $userId)->where('email', $email)->first();

        if (!$user) {
            Log::error('Usuario no encontrado para verificación: '.$email);
            $request->session()->forget(['verification_email', 'verification_attempts']);
            return redirect()->route('register')
                ->with('error', 'Usuario no encontrado. Por favor regístrate nuevamente.');
        }

        // Verificar el código
        if ($user->code_verification !== $request->code) {
            Log::warning('Código incorrecto para usuario: '.$email);
            return back()
                   ->with('error', 'Código de verificación incorrecto. Intentos restantes: '.(3 - ($attempts + 1)))
                   ->withInput();
        }

        if ($user->isCodeExpired()) {
            Log::warning('Código expirado para usuario: '.$email);
            return back()
                   ->with('error', 'El código ha expirado. Por favor solicita uno nuevo.')
                   ->withInput();
        }

        // Marcar como verificado
        $user->update([
            'is_verified' => true,
            'email_verified_at' => now(),
            'code_verification' => null,
            'code_expiration' => null
        ]);

        // Limpiar la sesión
        $request->session()->forget([
            'verification_user_id',
            'verification_email', 
            'verification_attempts'
        ]);

        Log::info('Usuario verificado exitosamente: '.$email);
        
        return redirect()->route('login.vista');
    }

    public function resendCode(Request $request)
    {
        if (!$request->session()->has('verification_email')) {
            return redirect()->route('register');
        }

        $email = $request->session()->get('verification_email');
        $userId = $request->session()->get('verification_user_id');
        $user = User::where('id', $userId)->where('email', $email)->first();

        if (!$user) {
            $request->session()->forget(['verification_email', 'verification_attempts']);
            return redirect()->route('register');
        }

        try {
            // Generar nuevo código
            $newCode = $user->getCodeVerification();
            
            // Enviar nuevo email
            Mail::to($user->email)->send(new VerificationMail($user, $newCode));
            
            // Reiniciar contador de intentos
            $request->session()->put('verification_attempts', 0);
            
            Log::info('Código reenviado a: '.$email);
            
            return back()
                   ->with('success', 'Hemos enviado un nuevo código a tu correo electrónico.')
                   ->with('info', 'Tienes 3 intentos para ingresar el código correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al reenviar código: '.$e->getMessage());
            return back()
                   ->with('error', 'Error al reenviar el código. Por favor intenta nuevamente.');
        }
    }
}