<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo' => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|integer|min:1',
            'producto_id' => 'required|exists:productos,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
            'responsable' => 'nullable|string|max:255',
            'motivo' => 'required|string|max:500',

            'fecha_movimiento' => 'required|date',
            'fecha_registro' => 'required|date'
        ];
    }
}
