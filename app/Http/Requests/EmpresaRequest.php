<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
        'nombre' => 'required|string|max:100',
        'RUC' => 'required|string|max:20|unique:empresa',
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|max:100|unique:empresa',
        'direccion' => 'required|string|max:100',
        'Industria' => 'required|string|max:100',
        'representante_legal' => 'required|string',
        'fecha_fundacion' => 'required|date',
        'moneda' => 'required|string|size:3',
        'descripcion_de_la_empresa' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];
    }
}
