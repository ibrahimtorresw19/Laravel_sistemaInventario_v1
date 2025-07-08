<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     */
   
public function rules(): array
{
    return [
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::exists('users')->where(function ($query) {
                $query->where('is_verified', true);
                // Elimina la línea whereNull('deleted_at')
            }),
        ],
        'password' => 'required|string|min:8',
        'remember' => 'sometimes|boolean'
    ];
}
    

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ingresar un correo electrónico válido',
            'email.exists' => 'Las credenciales no coinciden con nuestros registros',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres'
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            back()
                ->withErrors($validator)
                ->withInput()
                ->with('new_csrf_token', csrf_token())
        );
    }
}