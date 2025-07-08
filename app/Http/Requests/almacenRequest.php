<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlmacenRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:500',
            'capacidad' => 'required|string|max:100',
            'activo' => 'required|boolean'
        ];
    }

    /**
     * Obtiene los mensajes de error personalizados para las reglas de validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del almacén es obligatorio',
            'nombre.unique' => 'Ya existe un almacén con este nombre',
            'ubicacion.required' => 'La ubicación es obligatoria',
            'capacidad.required' => 'La capacidad es obligatoria',
            'activo.required' => 'Debe especificar el estado del almacén'
        ];
    }

    /**
     * Obtiene los nombres de atributos personalizados para los errores.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre del almacén',
            'ubicacion' => 'ubicación',
            'capacidad' => 'capacidad'
        ];
    }
}