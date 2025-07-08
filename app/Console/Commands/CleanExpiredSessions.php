<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanExpiredSessions extends Command
{
    protected $signature = 'sessions:clean';
    protected $description = 'Clean expired sessions';

   public function handle()
{
    $files = Storage::files('framework/sessions');
    $lifetime = config('session.lifetime') * 60;
    $count = 0;

    foreach ($files as $file) {
        $sessionId = str_replace('framework/sessions/', '', $file);
        
        // Eliminar sesiones expiradas
        if (Storage::lastModified($file) < time() - $lifetime) {
            // Buscar usuario con esta sesión y limpiar
            User::where('session_id', $sessionId)
                ->update(['session_id' => null]);
                
            Storage::delete($file);
            $count++;
        }
    }

    // Limpiar usuarios con sesiones que ya no existen
    $usersWithInvalidSessions = User::whereNotNull('session_id')
        ->get()
        ->filter(function($user) {
            return !Storage::exists('framework/sessions/'.$user->session_id);
        });

    foreach ($usersWithInvalidSessions as $user) {
        $user->session_id = null;
        $user->save();
        $count++;
    }

    $this->info("Sesiones limpiadas: {$count} sesiones expiradas o inválidas.");
}
}
