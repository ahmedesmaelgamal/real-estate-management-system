<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractLocationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('put')) {
            return $this->update();
        }

        return $this->store();
    }

    /**
     * Validation rules for storing.
     */
    protected function store(): array
    {
        return [
            'title.en'    => 'nullable|sometimes|string|max:255',
            'title.ar'    => 'required|string|max:255',

            'lat'         => 'required',
            'long'        => 'required',
        ];
    }

    /**
     * Validation rules for updating.
     */
    protected function update(): array
    {
        return [
            'title.en'    => 'nullable|sometimes|string|max:255',
            'title.ar'    => 'required|string|max:255',

            'lat'         => 'required',
            'long'        => 'required',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            // Title EN
            'title.en.required' => trns('English title is required'),
            'title.en.string'   => trns('English title must be a string'),
            'title.en.max'      => trns('English title must not exceed 255 characters'),

            // Title AR
            'title.ar.required' => trns('Arabic title is required'),
            'title.ar.string'   => trns('Arabic title must be a string'),
            'title.ar.max'      => trns('Arabic title must not exceed 255 characters'),

            // Location EN
            'location.en.required' => trns('English location is required'),
            'location.en.string'   => trns('English location must be a string'),
            'location.en.max'      => trns('English location must not exceed 255 characters'),

            // Location AR
            'location.ar.required' => trns('Arabic location is required'),
            'location.ar.string'   => trns('Arabic location must be a string'),
            'location.ar.max'      => trns('Arabic location must not exceed 255 characters'),

            // Latitude
            'lat.required' => trns('Latitude is required'),


            // Longitude
            'long.required' => trns('Longitude is required'),
        ];
    }
}
