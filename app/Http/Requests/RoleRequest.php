<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            $instance = $this->route('role');
            $id = $instance->id;
        }
        return [
            'name' => 'required|string|min:3|unique:roles,name,'.$id,
            'ar_name' => 'required|string|min:3|unique:roles,ar_name,'.$id,
            'guard_name' => 'required|string|in:web,admin',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,id',
        ];
    }
}
