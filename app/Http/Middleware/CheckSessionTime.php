<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CheckSessionTime
{
    // Tiempo de inactividad en minutos (configurable)
    protected $timeout = 30;

    public function handle($request, Closure $next)
    {
        // Si no está autenticado, continuar
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $currentSessionId = Session::getId();

        // 1. Verificar si la sesión actual coincide con la registrada
        if ($this->isSessionInvalid($user, $currentSessionId)) {
            return $this->handleInvalidSession($user);
        }

        // 2. Verificar tiempo de inactividad
        if ($this->isSessionExpired()) {
            return $this->handleExpiredSession($user);
        }

        // Actualizar última actividad
        $this->updateLastActivity();

        return $next($request);
    }

    /**
     * Verifica si la sesión no coincide con la registrada
     */
    protected function isSessionInvalid($user, $currentSessionId)
    {
        return $user->session_id !== $currentSessionId;
    }

    /**
     * Verifica si la sesión ha expirado por inactividad
     */
    protected function isSessionExpired()
    {
        return Session::get('last_activity') < now()->subMinutes($this->timeout);
    }

    /**
     * Maneja el caso de sesión inválida (inicio de sesión en otro dispositivo)
     */
    protected function handleInvalidSession($user)
    {
        $this->forceLogout($user);
        Log::warning("Intento de acceso con sesión inválida - Usuario: {$user->id}");
        
        return redirect()->route('login')
               ->withErrors([
                   'email' => 'Has iniciado sesión en otro dispositivo/navegador. '.
                              'Por seguridad, esta sesión ha sido cerrada.'
               ]);
    }

    /**
     * Maneja el caso de sesión expirada por inactividad
     */
    protected function handleExpiredSession($user)
    {
        $this->forceLogout($user);
        Log::info("Sesión expirada por inactividad - Usuario: {$user->id}");
        
        return redirect()->route('login')
               ->withErrors([
                   'email' => 'Tu sesión ha expirado por inactividad. '.
                              'Por favor, ingresa nuevamente.'
               ]);
    }

    /**
     * Actualiza el timestamp de última actividad
     */
    protected function updateLastActivity()
    {
        Session::put('last_activity', now());
    }

    /**
     * Fuerza el cierre de sesión y limpia los registros
     */
    protected function forceLogout($user)
    {
        // Invalidar sesión anterior si existe
        if ($user->session_id && Storage::exists('framework/sessions/'.$user->session_id)) {
            Storage::delete('framework/sessions/'.$user->session_id);
        }

        // Limpiar session_id
        $user->session_id = null;
        $user->save();

        // Cerrar sesión
        Auth::logout();
        Session::flush();

        Log::debug("Sesión cerrada forzosamente para usuario: {$user->id}");
    }
}