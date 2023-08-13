<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLandRequest extends FormRequest
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
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size'=>'required|numeric',
        'location'=>'required|string',
        'price'=>'required|numeric',
        'property'=>'required|string',
        'contact_information'=>'required|string',
        ];
    }
}
