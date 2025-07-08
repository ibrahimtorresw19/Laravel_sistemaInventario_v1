<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index(){

     $usuario=User::all();
     return view('inventario.informacionUsuario' , compact('usuario'));

    }

    public function update(){
        
    }
}
