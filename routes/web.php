<?php
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\infoEmpresaController;
use App\Http\Controllers\infoUsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CambioClaveController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\movimientoInventarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inventarioController;
use App\Http\Controllers\inventarioFisicoController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\AvatarController;

// Rutas públicas (sin autenticación)
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
Route::get('/verification-code', [RegisterController::class, 'codeVerification'])->name('verification.code');
Route::post('/verify-code', [RegisterController::class, 'verifyCode'])->name('verification.verify');
Route::post('/resend-code', [RegisterController::class, 'resendCode'])->name('verification.resend');

// Login/Logout
Route::get('/login', [LoginController::class, 'index'])->name('login.vista');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::get('/cerrar_sesion', [LoginController::class, 'logout'])->name('cerrar.sesion');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/inicio', [inventarioController::class, 'inicio'])->name('inventario');
    
    // Perfil de usuario
    Route::get('/perfil', [infoUsuarioController::class, 'index'])->name('profile.index');
    Route::put('/perfil/{id}', [infoUsuarioController::class, 'update'])->name('profile.update');
    Route::post('/avatar/update', [AvatarController::class, 'update'])->name('avatar.update');
    
    // Cambio de contraseña
    Route::get('/cambio-de-clave', [CambioClaveController::class, 'index'])->name('cambioClave.index');
    Route::put('/cambio-clave', [CambioClaveController::class, 'update'])->name('password.update');
    
    // Empresa
    Route::get('/empresa', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::put('/empresas/{empresas}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::get('/Informacion-de-empresa', [infoEmpresaController::class, 'index'])->name('Infoempresa.index');
    Route::post('/Informacion-de-empresa', [infoEmpresaController::class, 'store'])->name('Infoempresa.store');
    
    // Categorías
    Route::get('/Categorias', [CategoriaController::class, 'index'])->name('categorias');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    
    // Proveedores
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
    
    // Productos
   Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
Route::put('/productos/{productos}', [ProductosController::class, 'update'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductosController::class, 'destroy'])->name('productos.destroy');

// Almacenes
    Route::get('/almacen', [AlmacenController::class, 'index'])->name('almacen.index');
    Route::post('/almacen', [AlmacenController::class, 'store'])->name('almacen.store');
    Route::put('/almacen/{almacen}', [AlmacenController::class, 'update'])->name('almacen.update');
    Route::delete('/almacen/{almacen}', [AlmacenController::class, 'destroy'])->name('almacen.destroy');
    
    // Inventario Físico
    Route::get('/inventarioFisico', [InventarioFisicoController::class, 'index'])->name('inventarioFisico');
    Route::post('/inventarioFisico', [InventarioFisicoController::class, 'store'])->name('inventarioFisico.store');
    Route::put('/inventarioFisico/{inventario_fisico}', [InventarioFisicoController::class, 'update'])->name('inventarioFisico.update');
    Route::delete('/inventarioFisico/{inventario_fisico}', [InventarioFisicoController::class, 'destroy'])->name('inventarioFisico.destroy');
    
    // Movimientos de Inventario
    Route::get('/MovimientoDeInventario', [movimientoInventarioController::class, 'index'])->name('movimientos.index');
    Route::post('/MovimientoDeInventario', [movimientoInventarioController::class, 'store'])->name('movimientos.store');
     Route::delete('/movimientos/{movimiento}', [MovimientoInventarioController::class, 'destroy'])->name('movimientos.destroy');
    // Reportes PDF
    Route::get('/categorias/pdf', [pdfController::class, 'generarPDF'])->name('categorias.pdf');
    Route::get('/Almacen/pdf', [pdfController::class, 'generarPDFAlmacen'])->name('Almacen.pdf');
    Route::get('/Productos/pdf', [pdfController::class, 'generarPDFProductos'])->name('Productos.pdf');
    Route::get('/Proveedores/pdf', [pdfController::class, 'generarPDFProveedores'])->name('Proveedores.pdf');
    Route::get('/Movimientos/pdf', [pdfController::class, 'generarPDFMovimientos'])->name('Movimientos.pdf');
    Route::get('/Inventario_Fisico/pdf', [pdfController::class, 'generarPDFInventario_Fisico'])->name('inventario_fisico.pdf');
});
