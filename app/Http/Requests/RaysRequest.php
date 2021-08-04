<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaysRequest extends FormRequest
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
            $instance = $this->route('ray');
            $id = $instance->id;
        }
        return [
            'ar_name' => 'required|string|unique:rays_types,ar_name,'.$id,
            'en_name' => 'required|string|unique:rays_types,en_name,'.$id,
        ];
    }
}
