<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\categorias;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Cambiado a 'categoria' para coincidir con el parámetro de ruta
        $this->authorizeResource(categorias::class, 'categoria');
    }

    public function index()
    {
        $categorias = categorias::where('user_id', Auth::id())->paginate(5);
        return view('inventario.Categorias', compact('categorias'));
    }

    public function store(CategoriaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['activo'] = $request->estado == '1';
            $data['user_id'] = auth()->id(); // Asignación obligatoria

            $categoria = categorias::create($data);
            
            Log::info('Categoría creada', [
                'id' => $categoria->id,
                'user_id' => auth()->id(),
                'data' => $data
            ]);

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría creada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al crear categoría', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                   ->withInput()
                   ->with('error', 'Error al crear la categoría: '.$e->getMessage());
        }
    }

    public function update(CategoriaRequest $request, categorias $categoria)
    {
        try {
            // Verificación explícita de propiedad
            $this->authorize('update', $categoria);

            $data = $request->validated();
            $data['activo'] = $request->estado == '1';

            $categoria->update($data);
            
            Log::info('Categoría actualizada', [
                'id' => $categoria->id,
                'user_id' => auth()->id()
            ]);

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría actualizada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría', [
                'id' => $categoria->id,
                'error' => $e->getMessage()
            ]);
            return back()
                   ->with('error', 'Error al actualizar: '.$e->getMessage());
        }
    }

    public function destroy(categorias $categoria)
    {
        try {
            // Verificación explícita de propiedad
            $this->authorize('delete', $categoria);

            $categoria->delete();
            
            Log::info('Categoría eliminada', [
                'id' => $categoria->id,
                'user_id' => auth()->id()
            ]);

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría', [
                'id' => $categoria->id,
                'error' => $e->getMessage()
            ]);
            return back()
                   ->with('error', 'Error al eliminar: '.$e->getMessage());
        }
    }
}
