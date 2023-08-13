<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
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
        'size'=>'required|numeric',
        'price'=>'required|numeric',
        'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'property'=>'required|string',
        'renting_period'=>'required',
        'rating'=>'nullable',
        'contact_information'=>'required|numeric'
        ];
    }
}
