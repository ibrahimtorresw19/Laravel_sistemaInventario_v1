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
        $this->authorizeResource(categorias::class, 'categoria');
    }
  
 public function index()
{
    // Depuración avanzada
    Log::debug('Usuario autenticado ID: '.auth()->id());
    Log::debug('Consultando categorías para el usuario...');
    
    // Obtener categorías aplicando el scope del usuario
    $categorias = categorias::where('user_id', Auth::id())->paginate(5);
    
    Log::debug('Total categorías encontradas: '.$categorias->count());
    Log::debug('Primeras categorías:', $categorias->take(3)->toArray());
    
    return view('inventario.Categorias', compact('categorias'));
}

    public function store(CategoriaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['activo'] = $request->estado == '1';
            $data['user_id'] = auth()->id(); // Asignación explícita
            
            Log::debug('Creando categoría con datos:', $data);
            
            $categoria = categorias::create($data);
            
            Log::debug('Categoría creada exitosamente ID: '.$categoria->id);

            return redirect()
                   ->route('categorias')
                   ->with([
                       'success' => 'Categoría creada exitosamente',
                       'new_category_id' => $categoria->id
                   ]);

        } catch (\Exception $e) {
            Log::error('Error al crear categoría: '.$e->getMessage());
            Log::error('StackTrace: '.$e->getTraceAsString());
            
            return back()
                   ->withInput()
                   ->with('error', 'Error al crear la categoría: '.$e->getMessage());
        }
    }

    public function update(CategoriaRequest $request, categorias $categoria)
    {
        try {
            Log::debug('Actualizando categoría ID: '.$categoria->id);
            Log::debug('Datos recibidos:', $request->validated());
            
            $data = $request->validated();
            $data['activo'] = $request->estado == '1';

            $categoria->update($data);
            
            Log::debug('Categoría actualizada exitosamente');

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
            Log::debug('Eliminando categoría ID: '.$categoria->id);
            
            $categoria->delete();
            
            Log::debug('Categoría eliminada exitosamente');

            return redirect()
                   ->route('categorias')
                   ->with('success', 'Categoría eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: '.$e->getMessage());
            return back()->with('error', 'Error al eliminar: '.$e->getMessage());
        }
    }
}
