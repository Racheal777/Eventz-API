<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => ['required', 'string'],
            'location' => ['required', 'string'],
            'category' => ['required'],
            'date' => ['required', 'date'],
            'time' => ['required', 'time'],
            //'organizer_id' => ['required'],
            'flier' => ['required, image|mimes:jpg,png,jpeg,gif,svg|max:2048'],
        ];
    }
}
