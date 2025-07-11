<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\InventarioFisico_Request;
use App\Models\inventario_fisico;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class InventarioFisicoController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth'); // Primero verifica autenticación
        $this->authorizeResource(inventario_fisico::class, 'inventarioFisico'); // Cambiado a minúscula camelCase
    }

    public function index()
    {
        Log::info('Usuario '.auth()->id().' accediendo a inventarios');
        
        $datas = inventario_fisico::where('user_id', Auth::id())->paginate(5);
        return view('inventario.inventario_fisico', compact('datas'));
    }

    public function store(InventarioFisico_Request $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id(); // Asignación obligatoria
            
            Log::debug('Creando inventario con datos:', $data);
            
            $inventario = inventario_fisico::create($data);
            
            Log::info('Inventario creado ID:'.$inventario->id.' por usuario:'.auth()->id());

            return redirect()
                   ->route('inventarioFisico')
                   ->with('success', 'Inventario creado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al crear inventario: '.$e->getMessage());
            return back()
                   ->withInput()
                   ->with('error', 'Error al crear el inventario: '.$e->getMessage());
        }
    }

    public function update(InventarioFisico_Request $request, inventario_fisico $inventario_fisico)
    {
        try {
            Log::debug('Intentando actualizar inventario ID:'.$inventario_fisico->id);
            
            $data = $request->validated();
            $inventario_fisico->update($data);
            
            Log::info('Inventario actualizado ID:'.$inventario_fisico->id);

            return redirect()
                   ->route('inventarioFisico')
                   ->with('success', 'Inventario actualizado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar inventario: '.$e->getMessage());
            return back()
                   ->withInput()
                   ->with('error', 'Error al actualizar: '.$e->getMessage());
        }
    }

    public function destroy(inventario_fisico $inventario_fisico)
    {
        try {
            Log::debug('Intentando eliminar inventario ID:'.$inventario_fisico->id);
            
            // Verificación explícita de propiedad (adicional a la política)
            if ($inventario_fisico->user_id !== auth()->id()) {
                Log::warning('Intento de eliminación no autorizado. Usuario:'.auth()->id().' Inventario:'.$inventario_fisico->id);
                abort(403, 'No tienes permiso para eliminar este inventario');
            }

            $inventario_fisico->delete();
            
            Log::info('Inventario eliminado ID:'.$inventario_fisico->id);

            return redirect()
                   ->route('inventarioFisico')
                   ->with('success', 'Inventario eliminado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar inventario: '.$e->getMessage());
            return back()
                   ->with('error', 'Error al eliminar: '.$e->getMessage());
        }
    }
}
