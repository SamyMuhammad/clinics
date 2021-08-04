<?php

namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatientFileRequest extends FormRequest
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
        $rules = [
            'file' => ['required', 'file'],
            'description' => ['required', 'string', 'min:3'],
            'type' => ['required', Rule::in(File::getEnumValues('type'))],
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            unset($rules['file']);
        }
        return $rules;
    }
}
