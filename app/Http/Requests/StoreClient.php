<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
            'name' => 'required|max:25|min:3',
            'ruc' => 'alpha_dash|required|max:25|unique:clients,ruc',
            'code' => 'alpha_dash|required|max:25|unique:clients,code',
            'email' => 'email|max:25|unique:clients,email',
            'id'=> 'int'

        ];
    }
}
