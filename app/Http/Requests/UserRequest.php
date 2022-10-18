<?php

namespace App\Http\Requests;

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
        return false;
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
            // 'name' => ['required', 'string'],
            // 'email' => ['required', 'email', 'unique:users', 'string'],
            // 'password' => ['min: 6', 'required', 'confirmed'],
            // 'username' => ['required', 'string'],
            // 'location' => [ 'string', Rule::when(true,['required',])],
            // 'contact' => ['integer', 'min:10', Rule::when(true,['required',])],
            // 'image' => [Rule::when(true,['required', 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',])],
            // 'description' => ['string', Rule::when(true,['required',])]
        ];
    }
}
