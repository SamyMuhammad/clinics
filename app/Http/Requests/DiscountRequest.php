<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $instance = $this->route('discount');
            $id = $instance->id;
        }
        return [
            'ar_name' => ['required', 'string', 'min:3', 'max:191', 'regex:/^[\p{Arabic} _-]+$/u', 'unique:discounts,ar_name,'.$id],
            'en_name' => ['required', 'string', 'min:3', 'max:191', 'regex:/^[A-Za-z _-]+$/', 'unique:discounts,en_name,'.$id],
            'type' => ['required', 'string', 'in:percentage,fixed'],
            'amount' => ['required', 'numeric', 'min:1', 'regex:/^\d*(\.\d{1,4})?$/'], // matches decimal(10,4)
        ];
    }
}
