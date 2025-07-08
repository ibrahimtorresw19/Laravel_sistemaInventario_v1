<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Almacen;
use App\Models\Productos;
use App\Models\Movimiento_de_Inventario;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\MovimientoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MovimientoInventarioController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Movimiento_de_Inventario::class, 'movimiento');
    }

    public function index()
    {
        $this->authorize('viewAny', Movimiento_de_Inventario::class);
        
        $movimientos = Movimiento_de_Inventario::with(['user', 'almacen', 'producto'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(5);
        
        $productos = Productos::where('user_id', Auth::id())->get();
        $almacenes = Almacen::where('user_id', Auth::id())->get();

        return view('inventario.movimiento_inventario', compact('movimientos', 'productos', 'almacenes'));
    }

    public function store(MovimientoRequest $request)
    {
        $this->authorize('create', Movimiento_de_Inventario::class);
        
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            
            $movimiento = Movimiento_de_Inventario::create($data);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Movimiento registrado correctamente',
                    'data' => $movimiento
                ]);
            }

            return redirect()->route('movimientos.index')
                   ->with('success', 'Movimiento registrado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al crear movimiento: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el movimiento: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Error al crear el movimiento: ' . $e->getMessage()]);
        }
    }

    public function update(MovimientoRequest $request, Movimiento_de_Inventario $movimiento)
    {
        $this->authorize('update', $movimiento);
        
        try {
            $movimiento->update($request->validated());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Movimiento actualizado correctamente',
                    'data' => $movimiento
                ]);
            }

            return redirect()->route('movimientos.index')
                   ->with('success', 'Movimiento actualizado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar movimiento ID '.$movimiento->id.': '.$e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el movimiento: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Error al actualizar el movimiento: ' . $e->getMessage()]);
        }
    }

    public function destroy(Movimiento_de_Inventario $movimiento)
    {
        $this->authorize('delete', $movimiento);
        
        try {
            $movimiento->delete();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Movimiento eliminado exitosamente'
                ]);
            }

            return redirect()->route('movimientos.index')
                   ->with('success', 'Movimiento eliminado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar movimiento ID '.$movimiento->id.': '.$e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el movimiento: '.$e->getMessage()
                ], 500);
            }

            return redirect()->back()
                   ->with('error', 'Error al eliminar el movimiento: '.$e->getMessage());
        }
    }
}