<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectSaleRequest extends FormRequest
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
            'city' => 'required',
            'name' => 'required|max:55',
            'total_order' => 'required',
            'distr_id' => 'required',
            'items' => 'required|json'
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
            'city.required' => 'La ciudad es requerida.',
            'name.required' => 'El nombre es requerido.',
            'total_order.required' => 'El total de la orden, es requerido.',
            'items.required' => 'Seleccione productos para añadir a la venta.',
        ];
    }
}
