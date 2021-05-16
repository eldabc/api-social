<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:55',
            'img' => 'nullable',
            'phone' => 'numeric|required',
            'email' => 'email|required|unique:users',
            'accept_terms' => 'required',
            'password' => 'required_if:provider,==,""',//|confirmed
            'provider' => 'required_if:password,==,""'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.max:55' => 'El nombre debe tener un máximo de 55 caracteres.',
            'email.required' => 'El correo es requerido.',
            'email.email' => 'El correo no es correcto.',
            'email.unique' => 'El correo, ya está siendo usado por otro usuario.',
            'accept_terms' => 'Debe aceptar términos.',
            'password.required_if' => 'La contraseña es requerida.',
            'provider.required_if' => 'Registro con redes sociales, no ha enviado el proveedor.',
        ];
    }
}
