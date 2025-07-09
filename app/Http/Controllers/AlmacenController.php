<?php

namespace App\Http\Controllers;

use App\Models\almacen;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\almacenRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AlmacenController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(almacen::class, 'almacen'); // Nota: 'almacen' en minúsculas
    }

    public function index(): View
    {
        $almacenes = almacen::where('user_id', Auth::id())->paginate(5);
        return view('inventario.Almacen', compact('almacenes'));
    }

    public function store(almacenRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['activo'] = $request->boolean('activo');
        $validatedData['user_id'] = Auth::id();

        almacen::create($validatedData);

        return redirect()
            ->route('almacen.index')
            ->with('success', 'Almacén creado exitosamente');
    }

    public function update(almacenRequest $request, almacen $almacen): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['activo'] = $request->boolean('activo');

        $almacen->update($validatedData);

        return redirect()
            ->route('almacen.index')
            ->with('success', 'Almacén actualizado exitosamente');
    }

    public function destroy(almacen $almacen): RedirectResponse
    {
        $almacen->delete();

        return redirect()
            ->route('almacen.index')
            ->with('success', 'Almacén eliminado exitosamente');
    }
}
