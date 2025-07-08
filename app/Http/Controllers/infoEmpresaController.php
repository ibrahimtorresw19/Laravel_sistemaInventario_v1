<?php

namespace App\Http\Controllers;

use App\Models\EmpresaModel;
use App\Http\Requests\EmpresaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Asegúrate de importar el controlador base correctamente
use App\Http\Controllers\Controller;

class InfoEmpresaController extends Controller
{
    /**
     * Constructor - Protege las rutas con autenticación
     */
    public function __construct()
    {
        // Verifica primero si el método middleware existe
        if (method_exists($this, 'middleware')) {
            $this->middleware('auth');
        }
    }
  
    /**
     * Muestra el formulario de creación de empresa
     */
    public function index()
    {
        // Verifica si el usuario ya tiene una empresa
        if (EmpresaModel::where('user_id', Auth::id())->exists()) {
            return redirect()->route('empresas.index');
        }
        
        return view('inventario.informacion_empresa');
    }

    /**
     * Almacena una nueva empresa
     */
    public function store(EmpresaRequest $request)
    {
        // Verificación manual de autorización
        if (EmpresaModel::where('user_id', Auth::id())->exists()) {
            abort(403, 'Ya tienes una empresa registrada');
        }

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('empresa_images', 'public');
            $data['imagen'] = $imagePath;
        }

        EmpresaModel::create($data);

        return redirect()->route('empresas.index')
               ->with('success', 'Empresa creada exitosamente');
    }
}