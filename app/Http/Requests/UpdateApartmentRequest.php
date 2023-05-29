<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'phone_number'=>'nullable|numeric|starts_with:09|digits:10',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size'=>'nullable|numeric|min:40|max:500',
            'location'=>'nullable|string',
            'price'=>'nullable|numeric',
            'view'=>'nullable|string',
            'room_number'=>'nullable|numeric',
            'bathrooms'=>'nullable|numeric',
            'cladding'=>'nullable',
            'number_of_floor'=>'nullable|numeric',
            'property'=>'nullable|string',
            'renting_period'=>'nullable|string',
            'type'=>'nullable',
        ];
    }
}
