<?php

namespace App\Http\Controllers;

use App\Models\EmpresaModel;
use App\Http\Requests\EmpresaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    /**
     * Mostrar listado de empresas del usuario actual
     */
    public function index()
    {
        try {
            $empresas = EmpresaModel::where('user_id', Auth::id())->get();
            
            return view('inventario.empresa', [
                'empresas' => $empresas,
                'current_user_id' => Auth::id() // Para debugging en la vista
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al listar empresas: ' . $e->getMessage());
            return view('inventario.empresa', ['empresas' => []])
                ->with('error', 'Error al cargar las empresas');
        }
    }

    /**
     * Actualizar empresa existente
     */
    public function update(EmpresaRequest $request, EmpresaModel $empresa)
    {
        try {
            // Verificación mejorada con logs
            Log::info('Intentando actualizar empresa', [
                'user_id' => Auth::id(),
                'empresa_user_id' => $empresa->user_id,
                'empresa_id' => $empresa->id
            ]);

            if ($empresa->user_id !== Auth::id()) {
                Log::warning('Intento de actualización no autorizado', [
                    'auth_user' => Auth::id(),
                    'empresa_user' => $empresa->user_id
                ]);
                return back()->with('error', 'No tienes permiso para actualizar esta empresa');
            }

            $validated = $request->validated();
            
            // Manejo de la imagen con verificación de existencia
            if ($request->hasFile('imagen')) {
                // Validar que la imagen sea válida
                if (!$request->file('imagen')->isValid()) {
                    throw new \Exception('La imagen no es válida');
                }
                
                // Eliminar la imagen anterior si existe
                if ($empresa->imagen && Storage::disk('public')->exists($empresa->imagen)) {
                    Storage::disk('public')->delete($empresa->imagen);
                }
                
                // Guardar la nueva imagen
                $imagePath = $request->file('imagen')->store('empresa_images', 'public');
                $validated['imagen'] = $imagePath;
            } elseif ($request->has('eliminar_logo') && $request->eliminar_logo) {
                // Eliminar la imagen si se marca el checkbox y existe
                if ($empresa->imagen && Storage::disk('public')->exists($empresa->imagen)) {
                    Storage::disk('public')->delete($empresa->imagen);
                }
                $validated['imagen'] = null;
            }
            
            // Actualización con verificación
            if (!$empresa->update($validated)) {
                throw new \Exception('No se pudo actualizar la empresa en la base de datos');
            }
            
            return redirect()->route('empresas.index')
                   ->with('success', 'Empresa actualizada correctamente');
                   
        } catch (\Exception $e) {
            Log::error('Error al actualizar empresa: ' . $e->getMessage());
            return back()->withInput()
                   ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}