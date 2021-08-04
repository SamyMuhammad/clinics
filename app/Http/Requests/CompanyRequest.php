<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = '';
        if ($this->isMethod('patch')) {
            $instance = $this->route('company');
            $id = $instance->id;
        }
        return [
            'ar_name' => 'required|string',
            'en_name' => 'required|string',
            'phone' => 'required|numeric|unique:companies,phone,'.$id,
            'email' => 'required|email|unique:companies,email,'.$id,
            'city' => 'required|string',
            'address' => 'required|string',
        ];
    }
}
