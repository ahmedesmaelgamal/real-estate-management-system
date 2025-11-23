<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssociationModelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('put')) {
            return $this->update();
        } else {
            return $this->store();
        }
    }

    protected function store(): array
    {
        return [
            'title.en' => 'nullable|sometimes|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'nullable|sometimes|string|max:1000',
            'description.ar' => 'required|string|max:1000',
            'status' => 'nullable|boolean',
        ];
    }

    protected function update(): array
    {
        return [
            'title.en' => 'nullable|sometimes|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'nullable|sometimes|string|max:1000',
            'description.ar' => 'required|string|max:1000',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            // Title EN
            'title.en.required' => trns('English title is required'),
            'title.en.string' => trns('English title must be a string'),
            'title.en.max' => trns('English title must not exceed 255 characters'),

            // Title AR
            'title.ar.required' => trns('Arabic title is required'),
            'title.ar.string' => trns('Arabic title must be a string'),
            'title.ar.max' => trns('Arabic title must not exceed 255 characters'),

            // Description EN
            'description.en.required' => trns('English description is required'),
            'description.en.string' => trns('English description must be a string'),
            'description.en.max' => trns('English description must not exceed 1000 characters'),

            // Description AR
            'description.ar.required' => trns('Arabic description is required'),
            'description.ar.string' => trns('Arabic description must be a string'),
            'description.ar.max' => trns('Arabic description must not exceed 1000 characters'),

            // Status
            'status.boolean' => trns('Status must be true or false'),
            'status.required' => trns('Status is required'),
        ];
    }

}
