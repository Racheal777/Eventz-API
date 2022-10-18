<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerRequest extends FormRequest
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
           
            'location' => ['required', 'string'],
            'contact' => ['required','integer', 'min:10'],
            'image' => ['required, image|mimes:jpg,png,jpeg,gif,svg|max:2048'],
            'description' => ['required', 'string']
        ];
    }
}
