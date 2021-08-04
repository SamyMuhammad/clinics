<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClinicRequest extends FormRequest
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
            $instance = $this->route('clinic');
            $id = $instance->id;
        }
        return [
            'ar_name' => 'required|string|unique:clinics,ar_name,'.$id,
            'en_name' => 'required|string|unique:clinics,en_name,'.$id,
            'doctors' => 'nullable|array',
            'doctors.*' => ['nullable', Rule::exists('users', 'id')->where(function ($query) {
                return $query->where('job', 'doctor');
            })]
        ];
    }
}
