<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractTermsRequest extends FormRequest
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
            'description.en' => 'nullable|sometimes|string',
            'description.ar' => 'required|string',
            "taken" => "nullable|sometimes",
        ];
    }

    protected function update(): array
    {
        return [
            'title.en' => 'nullable|sometimes|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'nullable|sometimes|string',
            'description.ar' => 'required|string',
            "taken" => "nullable|sometimes",
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
        ];
    }
}
