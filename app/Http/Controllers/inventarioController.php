<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\inventario_Fisico;
use Illuminate\Support\Facades\Auth;
use App\Models\productos;
use App\Models\Almacen;
use App\Models\Proveedor;
use App\Models\movimiento_de_inventario;


class inventarioController extends Controller
{

     public function inicio()
{

      $userId = Auth::id(); 
           $Countcategorias = Categorias::where('user_id', $userId)->count();
        $CountProductos = Productos::where('user_id', $userId)->count();
         $CountAlmacen=Almacen::where('user_id', $userId)->count();
        $Countproveedores = Proveedor::where('user_id', $userId)->count();
          $CountInventarioFisico = inventario_Fisico::where('user_id', $userId)->count();
         $CountMovimiento = movimiento_de_inventario::where('user_id', $userId)->count();

    return view('inventario.inicio', compact('Countcategorias','CountProductos','Countproveedores', 'CountAlmacen' ,'CountInventarioFisico', 'CountMovimiento'));
}
}
