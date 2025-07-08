<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CambioClaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('La contraseña actual es incorrecta');
                    }
                }
            ],
            'password' => 'required|confirmed|min:8|different:current_password'
        ];
    }

    public function messages()
    {
        return [
            'password.different' => 'La nueva contraseña debe ser diferente a la actual',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres'
        ];
    }
}