<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest
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
            'client_id' => 'required|int',
            'exchange_rate_id' => 'required|int',
            'code' => 'alpha_dash|required|max:25|min:3|unique:invoices,code',
            'description' => 'required',
            'active' => 'boolean'
        ];
    }
}
