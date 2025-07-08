<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Proveedor;
use App\Http\Requests\ProductosRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductosController extends Controller 
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Productos::class, 'producto'); // Cambiado a 'producto' singular
    }

    public function index()
    {
        $this->authorize('viewAny', Productos::class);
        
        $productos = Productos::with(['categoria', 'proveedor', 'user'])
                    ->where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->get();

        $categorias = Categorias::where('user_id', Auth::id())->get();
        $proveedores = Proveedor::where('user_id', Auth::id())->get();

        return view('inventario.Productos', 
            compact('productos', 'categorias', 'proveedores')
        );
    }

    public function store(ProductosRequest $request)
    {
        $this->authorize('create', Productos::class);
        
        try {
            $data = $request->validated();
            $data['activo'] = $request->boolean('activo');
            $data['user_id'] = auth()->id();

            if ($request->hasFile('imagen')) {
                $data['imagen'] = $request->file('imagen')->store('productos', 'public');
            }

            Productos::create($data);
            
            return redirect()->route('productos.index')
                ->with('success', 'Producto creado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al crear producto: '.$e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al crear el producto: '.$e->getMessage());
        }
    }

    public function update(ProductosRequest $request, Productos $producto)
    {
        $this->authorize('update', $producto);
        
        try {
            $data = $request->validated();
            $data['activo'] = $request->boolean('activo');

            if ($request->hasFile('imagen')) {
                if ($producto->imagen) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $data['imagen'] = $request->file('imagen')->store('productos', 'public');
            }

            $producto->update($data);
            
            return redirect()->route('productos.index')
                ->with('success', 'Producto actualizado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar producto ID '.$producto->id.': '.$e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al actualizar el producto: '.$e->getMessage());
        }
    }

    public function destroy(Productos $producto)
    {
        $this->authorize('delete', $producto);
        
        try {
            // Registro para depuración
            Log::info('Eliminando producto', [
                'user_id' => Auth::id(),
                'producto_id' => $producto->id,
                'producto_user_id' => $producto->user_id
            ]);

            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            
            $producto->delete();
            
            return redirect()->route('productos.index')
                ->with('success', 'Producto eliminado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar producto ID '.$producto->id.': '.$e->getMessage());
            return back()->with('error', 'Error al eliminar el producto: '.$e->getMessage());
        }
    }
}