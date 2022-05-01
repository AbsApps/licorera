<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name' => 'required|max:25|min:3|unique:products,name',
            'description' => 'required|max:25|min:3',
            'sku' => 'alpha_dash|required|max:25|min:3|unique:products,sku',
            'price' => 'numeric',
            'active' => 'boolean'

        ];
    }
}
