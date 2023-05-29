<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone_number'=>'required|numeric|starts_with:09|digits:10',
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size'=>'required|numeric|min:40|max:500',
            'location'=>'required|string',
            'price'=>'required|numeric',
            'view'=>'required|string',
            'room_number'=>'required|numeric',
            'bathrooms'=>'required|numeric',
            'cladding'=>'required',
            'number_of_floor'=>'required|numeric',
            'property'=>'required|string',
            'renting_period'=>'required|string',
            'type'=>'required',
        ];
    }
}
