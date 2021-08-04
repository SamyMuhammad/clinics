<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            $instance = $this->route('admin');
            $id = $instance->id;
        }
        $rules = [
            'name' => 'required|string|min:3',
            'phone' => 'required|numeric|unique:admins,phone,'.$id,
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image',
            'address' => 'nullable|string',
            'roles' => 'required|array',
            'roles.*' => 'required|exists:roles,id',
        ];
        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }
        return $rules;
    }
}
