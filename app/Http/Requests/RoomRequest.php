<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        $id = NULL;
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $instance = $this->route('room');
            $id = $instance->id;
        }
        return [
            'room_number' => ['required', 'integer', 'unique:rooms,room_number,'.$id.',id,floor_number,'.$this->floor_number], // composite unique
            'floor_number' => ['required', 'integer', 'unique:rooms,floor_number,'.$id.',id,room_number,'.$this->room_number], // composite unique
            'beds_count' => ['required', 'integer']
        ];
    }
}
