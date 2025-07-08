<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function login(LoginRequest $request)
    {
        // Buscar usuario por email antes de autenticar
        $user = User::where('email', $request->email)->first();

        // Cerrar cualquier sesión previa si el usuario existe
        if ($user && $user->session_id) {
            $this->forceLogoutUser($user);
        }

        // Intentar autenticación
        if (!Auth::attempt($request->only('email', 'password'))) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Credenciales incorrectas'], 401);
            }
            return back()->withErrors(['email' => 'Credenciales incorrectas']);
        }

        $user = Auth::user();
        $currentSessionId = Session::getId();

        // Registrar nueva sesión
        $user->session_id = $currentSessionId;
        $user->save();

        // Regenerar la sesión por seguridad
        $request->session()->regenerate();

        // Registrar actividad
        Session::put('last_activity', now());

        // Log de acceso
        Log::info('Usuario '.$user->id.' ha iniciado sesión', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => $currentSessionId
        ]);

        // Respuesta para API
        if ($request->wantsJson()) {
            $TokenResult = $user->createToken('Token de Acceso Personal');
            return response()->json([
                'accessToken' => $TokenResult->plainTextToken,
                'token_type' => 'Bearer',
                'user' => $user->only(['id', 'name', 'email']),
                'session_id' => $currentSessionId
            ]);
        }

        // Redirigir a dashboard
        return redirect()->route('categorias')
               ->with('success', 'Bienvenido '.$user->name);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->forceLogoutUser($user);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Método para forzar cierre de sesión de un usuario
     */
    protected function forceLogoutUser(User $user)
    {
        // Eliminar archivo de sesión si existe
        if ($user->session_id && Storage::exists('framework/sessions/'.$user->session_id)) {
            Storage::delete('framework/sessions/'.$user->session_id);
        }

        // Limpiar session_id
        $user->session_id = null;
        $user->save();

        Log::info('Sesión cerrada forzosamente para usuario: '.$user->id);
    }
}