<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categorias;
use App\Models\productos;
use App\Models\proveedor;
use App\Models\almacen;
use App\Models\inventario_fisico;
use App\Models\movimiento_de_inventario;
use Barryvdh\DomPDF\Facade\Pdf;

class pdfController extends Controller
{
    public function generarPDF()
{
    $categorias = categorias::all();

    $pdf = Pdf::loadView('inventario.pdf', compact('categorias'));

    return $pdf->download('listado_categorias.pdf');

    // Si prefieres mostrar en el navegador en lugar de descargar:
    // return $pdf->stream('listado_categorias.pdf');
}

    public function generarPDFAlmacen()
{
    $almacenes= almacen::all();

    $pdf = Pdf::loadView('inventario.pdfAlmacen', compact('almacenes'));

    return $pdf->download('listado_Almacen.pdf');

    // Si prefieres mostrar en el navegador en lugar de descargar:
    // return $pdf->stream('listado_categorias.pdf');
}

   public function generarPDFProveedores()
{
    $proveedores= proveedor::all();

    $pdf = Pdf::loadView('inventario.pdfProveedor', compact('proveedores'));

    return $pdf->download('listado_proveedor.pdf');

    // Si prefieres mostrar en el navegador en lugar de descargar:
    // return $pdf->stream('listado_categorias.pdf');
}
   public function generarPDFInventario_Fisico()
{
    $datas= inventario_fisico::all();

    $pdf = Pdf::loadView('inventario.pdfInventarioFisico', compact('datas'));

    return $pdf->download('listado_inventario_fisico.pdf');

    // Si prefieres mostrar en el navegador en lugar de descargar:
    // return $pdf->stream('listado_categorias.pdf');
}

   public function generarPDFMovimientos()
{
    $movimientos= movimiento_de_inventario::all();

    $pdf = Pdf::loadView('inventario.pdfMovimientos', compact('movimientos'));

    return $pdf->download('listado_Movimientos.pdf');

    // Si prefieres mostrar en el navegador en lugar de descargar:
    // return $pdf->stream('listado_categorias.pdf');
}

   public function generarPDFproductos ()
{
    $productos= productos::all();

    $pdf = Pdf::loadView('inventario.pdfProductos', compact('productos'));

    return $pdf->download('listado_Productos.pdf');

    // Si prefieres mostrar en el navegador en lugar de descargar:
    // return $pdf->stream('listado_categorias.pdf');
}
}
