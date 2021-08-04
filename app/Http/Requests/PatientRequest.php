<?php

namespace App\Http\Requests;

use App\Models\Patient;
use App\Rules\RoomNotFull;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_emergency' => $this->is_emergency ?? false
        ]);
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
            $instance = $this->route('patient');
            $id = $instance->id;
        }
        return [
            'code' => 'required|numeric|unique:patients,code,'.$id,
            'ar_name' => 'required|string|max:191',
            'en_name' => 'required|string|max:191',
            'phone' => 'required|numeric|unique:patients,phone,'.$id,
            'national_id' => 'required|numeric|unique:patients,national_id,'.$id,
            'nationality' => 'required|string|max:191',
            'age' => 'required|numeric|min:1|max:255',
            'gender' => ['required', Rule::in(Patient::getEnumValues('gender'))],
            'social_status' => ['required', Rule::in(Patient::getEnumValues('social_status'))],
            'address' => 'nullable|string|max:191',
            'type' => ['required', Rule::in(Patient::getEnumValues('type'))],
            'payment_method' => ['required', Rule::in(Patient::getEnumValues('payment_method'))],
            'status' => 'sometimes',
            'doctors' => 'required|array',
            'doctors.*' => ['required', Rule::exists('users', 'id')->where(function ($query) {
                return $query->where('job', 'doctor');
            })],
            'files' => 'nullable|array',
            'files.*' => 'nullable|file',
            'company_id' => 'nullable|required_if:payment_method,insurance_company|exists:companies,id',
            'discount_id' => 'nullable|required_if:payment_method,cash_with_discount|exists:discounts,id',
            'room_id' => ['nullable', 'exists:rooms,id', new RoomNotFull],
            'is_emergency' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'code' => __('patients.code'),
            'ar_name' => __('patients.ar_name'),
            'en_name' => __('patients.en_name'),
            'phone' => __('patients.phone'),
            'national_id' => __('patients.national_id'),
            'nationality' => __('patients.nationality'),
            'age' => __('patients.age'),
            'gender' => __('patients.gender.title'),
            'social_status' => __('patients.social_status.title'),
            'address' => __('patients.address'),
            'type' => __('patients.type.title'),
            'payment_method' => __('patients.payment_method.title'),
            'status' => __('patients.status.title'),
            'is_emergency' => __('patients.is_emergency'),
        ];
    }
}
