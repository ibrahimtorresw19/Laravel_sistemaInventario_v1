<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules()
{
    $producto = $this->route('producto');
    $productoId = $producto ? $producto->id : null;

    return [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:500',
        'codigo_barras' => [
            'nullable',
            'string',
            'max:50',
            Rule::unique('productos')->ignore($productoId)
        ],
        'codigo_interno' => [
            'required',
            'string',
            'max:50',
            Rule::unique('productos')->ignore($productoId)
        ],
        'precio_compra' => 'required|numeric|min:0',
        'precio_venta' => 'required|numeric|min:0|gte:precio_compra',
        'stock' => 'required|integer|min:0',
        'stock_minimo' => 'required|integer|min:0|lte:stock',
        'categoria_id' => 'required|exists:categorias,id',
        'proveedor_id' => 'nullable|exists:proveedores,id',
        'unidad_medida' => 'required|in:unidad,kg,g,l,ml,paquete',
        'activo' => 'required|boolean',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'fecha_ultima_venta' => 'nullable|date|before_or_equal:today',
        'fecha_caducidad' => 'nullable|date|after_or_equal:today',
    ];
}
}