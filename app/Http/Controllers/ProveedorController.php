<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\proveedor;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class ProveedorController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(proveedor::class, 'proveedor');
    }

    public function index()
    {
        $proveedores = proveedor::where('user_id', Auth::id())->paginate(5);
        return view('inventario.Proveedor', compact('proveedores'));
    }

    public function store(ProveedorRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['activo'] = $validatedData['estado'] == '1';
        $validatedData['user_id'] = auth()->id();

        proveedor::create($validatedData);
        
        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor creado exitosamente');
    }


    public function update(ProveedorRequest $request, proveedor $proveedor): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['activo'] = $validatedData['estado'] == '1';
        
        $proveedor->update($validatedData);
        
        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente');
    }

    public function destroy(proveedor $proveedor): RedirectResponse
    {
        $proveedor->delete();
        
        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor eliminado exitosamente');
    }
}
