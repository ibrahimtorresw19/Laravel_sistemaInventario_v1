<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\InventarioFisico_Request;
use App\Models\inventario_fisico;

class InventarioFisicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(inventario_fisico::class, 'inventarioFisico');
    }

    /**
     * Muestra el listado de inventarios del usuario actual
     */
    public function index()
    {
        try {
            $inventarios = inventario_fisico::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

            return view('inventario.inventario_fisico', compact('inventarios'));

        } catch (\Exception $e) {
            Log::error('Error al listar inventarios: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar los inventarios');
        }
    }

    /**
     * Almacena un nuevo inventario físico
     */
    public function store(InventarioFisico_Request $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            
            $inventario = inventario_fisico::create($data);

            Log::info("Inventario creado ID: {$inventario->id} por usuario: " . auth()->id());

            return redirect()
                ->route('inventarioFisico')
                ->with('success', 'Inventario creado correctamente');

        } catch (\Exception $e) {
            Log::error("Error al crear inventario: " . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al crear el inventario: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un inventario existente
     */
    public function update(InventarioFisico_Request $request, inventario_fisico $inventarioFisico)
    {
        try {
            // Verificación explícita adicional
            if ($inventarioFisico->user_id !== auth()->id()) {
                Log::warning("Usuario " . auth()->id() . " intentó editar inventario de otro usuario");
                abort(403, 'No autorizado');
            }

            $inventarioFisico->update($request->validated());

            return redirect()
                ->route('inventarioFisico')
                ->with('success', 'Inventario actualizado correctamente');

        } catch (\Exception $e) {
            Log::error("Error al actualizar inventario ID: {$inventarioFisico->id}: " . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un inventario físico
     */
    public function destroy(inventario_fisico $inventarioFisico)
    {
        try {
            // Doble verificación de seguridad
            if ($inventarioFisico->user_id !== auth()->id()) {
                Log::alert("Intento no autorizado de eliminar inventario ID: {$inventarioFisico->id}");
                abort(403, 'Acción no autorizada');
            }

            // Verificación de estado antes de eliminar
            if ($inventarioFisico->estado === 'cerrado') {
                return back()->with('error', 'No se puede eliminar un inventario cerrado');
            }

            $inventarioFisico->delete();

            Log::info("Inventario eliminado ID: {$inventarioFisico->id}");

            return redirect()
                ->route('inventarioFisico')
                ->with('success', 'Inventario eliminado correctamente');

        } catch (\Exception $e) {
            Log::error("Error al eliminar inventario ID: {$inventarioFisico->id}: " . $e->getMessage());
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}|
