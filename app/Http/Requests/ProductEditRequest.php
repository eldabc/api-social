<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductEditRequest extends FormRequest
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
            'presentation' => 'required|integer',
            'stock' => 'required|integer',
            'shipping_value' => 'nullable',
            'delivery_time' => 'nullable',
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
            // 'name.required' => 'El nombre de producto es requerido.',
            // 'name.max:55' => 'El nombre de producto debe tener un máximo de 55 caracteres.',
            'presentation.required' => 'El tipo de presentation es requerida.',
            'presentation.integer' => 'El tipo de presentation debe ser un entero.',
            'stock.required' => 'El stock, es requerido.',
            'stock.integer' => 'El stock debe ser un número.',
        ];
    }
}
