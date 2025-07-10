<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\InventarioFisico_Request;
use App\Models\inventario_fisico;
use App\Models\User;

class InventarioFisicoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Constructor del controlador
     */
    public function __construct()
    {
        $this->authorizeResource(inventario_fisico::class, 'InventarioFisico');
    }

    /**
     * Muestra la lista de inventarios físicos del usuario autenticado
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $datas = inventario_fisico::where('user_id', Auth::id())->paginate(5);
        return view('inventario.inventario_fisico', compact('datas'));
    }

    /**
     * Almacena un nuevo inventario físico
     * 
     * @param InventarioFisico_Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InventarioFisico_Request $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();
            
            inventario_fisico::create($data);
            
            return redirect()
                ->route('inventarioFisico')
                ->with('success', 'Inventario creado correctamente');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el inventario: ' . $e->getMessage()]);
        }
    }

    /**
     * Actualiza un inventario físico existente
     * 
     * @param InventarioFisico_Request $request
     * @param inventario_fisico $inventario_fisico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InventarioFisico_Request $request, inventario_fisico $inventario_fisico)
    {
        try {
            $this->authorize('update', $inventario_fisico);
            
            $data = $request->validated();
            $inventario_fisico->update($data);
            
            return redirect()
                ->route('inventarioFisico')
                ->with('success', 'Inventario actualizado correctamente');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar el inventario: ' . $e->getMessage()]);
        }
    }

    /**
     * Elimina un inventario físico
     * 
     * @param inventario_fisico $inventario_fisico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(inventario_fisico $inventario_fisico)
    {
        $inventario_fisico->delete();
        
        return redirect()
            ->route('inventarioFisico')
            ->with('success', 'Inventario eliminado correctamente');
    }
}
