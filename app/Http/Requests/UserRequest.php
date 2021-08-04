<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            $instance = $this->route('user');
            $id = $instance->id;
        }
        $rules = [
            'name' => 'required|string|min:3',
            'phone' => 'required|numeric|unique:users,phone,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image',
            'job' => ['required', Rule::in(User::getEnumValues('job'))],
            'address' => 'nullable|string',
            'salary' => 'required|numeric|min:1|regex:/^\d*(\.\d{1,2})?$/',
            'contract_period' => 'required|string|min:1|max:191',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:roles,id',
        ];
        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }
        return $rules;
    }
}
