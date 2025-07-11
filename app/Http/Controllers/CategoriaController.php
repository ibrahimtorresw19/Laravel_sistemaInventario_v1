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
        $this->middleware('auth'); // Asegura autenticación primero
        $this->authorizeResource(categorias::class, 'categoria');
    }

    public function index()
    {
        Log::info('Usuario '.auth()->id().' accediendo a categorías');
        
        $categorias = categorias::where('user_id', Auth::id())->paginate(5);
        
        return view('inventario.Categorias', compact('categorias'));
    }

    public function store(CategoriaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['activo'] = $request->estado == '1';
            $data['user_id'] = auth()->id(); // Asignación obligatoria
            
            // Verificación adicional de seguridad
            if (auth()->guest()) {
                Log::warning('Intento de creación por usuario no autenticado');
                abort(403, 'No autenticado');
            }

            $categoria = categorias::create($data);
            
            Log::info('Categoría creada ID:'.$categoria->id.' por usuario:'.auth()->id());

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría creada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al crear categoría: '.$e->getMessage());
            return back()
                   ->withInput()
                   ->with('error', 'Error al crear la categoría: '.$e->getMessage());
        }
    }

    public function update(CategoriaRequest $request, categorias $categoria)
    {
        try {
            // Verificación explícita de propiedad
            if ($categoria->user_id !== auth()->id()) {
                Log::warning('Intento de edición no autorizado. Usuario:'.auth()->id().' Categoría:'.$categoria->id);
                abort(403, 'No tienes permiso para editar esta categoría');
            }

            $data = $request->validated();
            $data['activo'] = $request->estado == '1';

            $categoria->update($data);
            
            Log::info('Categoría actualizada ID:'.$categoria->id);

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría actualizada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría: '.$e->getMessage());
            return back()->with('error', 'Error al actualizar: '.$e->getMessage());
        }
    }

    public function destroy(categorias $categoria)
    {
        try {
            // Verificación explícita de propiedad
            if ($categoria->user_id !== auth()->id()) {
                Log::warning('Intento de eliminación no autorizado. Usuario:'.auth()->id().' Categoría:'.$categoria->id);
                abort(403, 'No tienes permiso para eliminar esta categoría');
            }

            $categoria->delete();
            
            Log::info('Categoría eliminada ID:'.$categoria->id);

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: '.$e->getMessage());
            return back()->with('error', 'Error al eliminar: '.$e->getMessage());
        }
    }
}
