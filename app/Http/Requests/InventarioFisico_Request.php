<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarioFisico_Request extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'observaciones' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'encargado' => 'required|string|max:255',
            'estado' => 'required|in:planificado,en_progreso,completado,cancelado'
        ];
    }
}
