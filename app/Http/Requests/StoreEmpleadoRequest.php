<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required',
            'dui' => 'required',
            'email' => 'required',
            'cargo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio',
            'dui.required' => 'El campo dui es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'cargo.required' => 'El campo cargo es obligatorio',
            'telefono.required' => 'El campo telefono es obligatorio',
            'direccion.required' => 'El campo direccion es obligatorio',
        ];
    }
}
