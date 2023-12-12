<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'color' => 'required|string|max:7'
        ];
    }
    public function messages()
    {
        return [
            'latitude.required' => 'Latitude is required!',
            'longitude.required' => 'Longitude is required!',
            'name.required' => 'Name is required!',
            'color.required' => 'Color is required!'
        ];
    }
}
