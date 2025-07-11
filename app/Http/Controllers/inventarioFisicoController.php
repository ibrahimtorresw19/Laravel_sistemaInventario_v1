<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InventarioFisico_Request;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\inventario_fisico;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InventarioFisicoController extends Controller
{

       use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(inventario_fisico::class, 'inventario_fisico');
    }


    public function index()
    {
        $datas = inventario_fisico::where('user_id', Auth::id())->paginate(5);
        return view('inventario.inventario_fisico', compact('datas'));
    }

    public function store(InventarioFisico_Request $request)
    {
        try {
            $data = $request->validated();
             $data['user_id'] = auth()->id();
            inventario_fisico::create($data);
            return redirect()->route('inventarioFisico')->with('success', 'Inventario creado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el inventario: ' . $e->getMessage()]);
        }
    }

public function update(InventarioFisico_Request $request, inventario_fisico $inventario_fisico)
{
    $data = $request->validated();
    $inventario_fisico->update($data);
    return redirect()->route('inventarioFisico')->with('success', 'Inventario actualizado correctamente');
}

  public function destroy(inventario_fisico $inventario_fisico){
    $inventario_fisico->delete();
    return redirect()->route('inventarioFisico')->with('success', 'Inventario eliminado correctamente');
}
}
