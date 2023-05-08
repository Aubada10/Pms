<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'string|min:4|max:12',
            'email'=>'required|email',
            'password'=>'required|min:8|max:10',
            'phone_number'=>'required|numeric|starts_with:09|digits:10',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
