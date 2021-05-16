<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'price' => 'required|integer',
            'description' => 'string|max:55',
            'phone' => 'required|integer',
            'phone_ws' => 'required',
            'user_id' => 'required|integer',
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
            'name.required' => 'El nombre de producto es requerido.',
            'name.max:55' => 'El nombre de producto debe tener un máximo de 55 caracteres.',
            'price.required' => 'El precio es requerido.',
            'price.integer' => 'El precio debe ser un entero.',
            'description.string' => 'La descripción debe ser una cadena.',
            'phone.required' => 'El teléfono es requerido.',
            'phone_ws.required' => 'El teléfono de WhatsApp, es requerido.',
            'user_id.required' => 'No se ha enviado id de user.',
        ];
    }
}
