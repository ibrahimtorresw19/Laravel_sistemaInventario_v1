<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CambioClaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CambioClaveController extends Controller
{
    public function index()
    {
        return view("inventario.cambio_contraseña");
    }

    public function update(CambioClaveRequest $request)
    {
        try {
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::logoutOtherDevices($request->password);

            return back()->with('success', 'Contraseña actualizada correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la contraseña: '.$e->getMessage());
        }
    }
}