<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        try {
            // Eliminar la imagen anterior si existe
            if ($user->avatar && Storage::exists('public/avatars/'.$user->avatar)) {
                Storage::delete('public/avatars/'.$user->avatar);
            }

            // Guardar la nueva imagen
            $avatarName = $user->id.'_avatar_'.time().'.'.$request->avatar->extension();
            
$path = $request->avatar->storeAs('avatars', $avatarName, 'public');

            // Actualizar el usuario
            $user->avatar = $avatarName;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar actualizado correctamente',
               'avatar_url' => asset('storage/avatars/'.$avatarName)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el avatar: '.$e->getMessage()
            ], 500);
        }
    }
}