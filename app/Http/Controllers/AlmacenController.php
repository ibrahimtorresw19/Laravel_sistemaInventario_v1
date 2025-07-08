<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\AlmacenRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AlmacenController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Almacen::class, 'almacen'); // Nota: 'almacen' en minúsculas
    }

    public function index(): View
    {
        $almacenes = Almacen::where('user_id', Auth::id())->paginate(5);
        return view('inventario.almacen', compact('almacenes'));
    }

    public function store(AlmacenRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['activo'] = $request->boolean('activo');
        $validatedData['user_id'] = Auth::id();

        Almacen::create($validatedData);

        return redirect()
            ->route('almacen.index')
            ->with('success', 'Almacén creado exitosamente');
    }

    public function update(AlmacenRequest $request, Almacen $almacen): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['activo'] = $request->boolean('activo');

        $almacen->update($validatedData);

        return redirect()
            ->route('almacen.index')
            ->with('success', 'Almacén actualizado exitosamente');
    }

    public function destroy(Almacen $almacen): RedirectResponse
    {
        $almacen->delete();

        return redirect()
            ->route('almacen.index')
            ->with('success', 'Almacén eliminado exitosamente');
    }
}