<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            "doctor_id" => ['required', Rule::exists('users', 'id')->where(function ($query){
                $query->where('job', 'doctor');
            })],
            "date" => ['required', 'date_format:D M d Y'], // "Fri Mar 05 2021"
            "reservation_time" => ['required', 'string'], // "1|3:00 AM"
            "patient_id" => ['required', 'exists:patients,id']
        ];
    }
}
