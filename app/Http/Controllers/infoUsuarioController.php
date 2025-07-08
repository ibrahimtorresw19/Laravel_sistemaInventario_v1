<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditarUser_Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class infoUsuarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        return view('inventario.informacionUsuario', compact('usuario'));
    }

    public function update(EditarUser_Request $request, $id)
    {
        // Buscar el usuario específico
        $user = User::findOrFail($id);
        
        // Verificar que el usuario autenticado es el dueño del perfil
        if ($user->id !== Auth::id()) {
            return back()->with('error', 'No tienes permisos para editar este perfil');
        }

        try {
            // Actualizar los datos validados
            $user->update($request->validated());
            
            return redirect()->route('profile.index')
                ->with('success', 'Perfil actualizado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el perfil: '.$e->getMessage())
                         ->withInput();
        }
    }
}