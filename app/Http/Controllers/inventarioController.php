<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\categorias;
use App\Models\inventario_Fisico;
use Illuminate\Support\Facades\Auth;
use App\Models\productos;
use App\Models\almacen;
use App\Models\proveedor;
use App\Models\movimiento_de_inventario;


class inventarioController extends Controller
{

     public function inicio()
{

      $userId = Auth::id(); 
           $Countcategorias = categorias::where('user_id', $userId)->count();
        $CountProductos = productos::where('user_id', $userId)->count();
         $CountAlmacen=almacen::where('user_id', $userId)->count();
        $Countproveedores = proveedor::where('user_id', $userId)->count();
          $CountInventarioFisico = inventario_fisico::where('user_id', $userId)->count();
         $CountMovimiento = movimiento_de_inventario::where('user_id', $userId)->count();

    return view('inventario.inicio', compact('Countcategorias','CountProductos','Countproveedores', 'CountAlmacen' ,'CountInventarioFisico', 'CountMovimiento'));
}
}
