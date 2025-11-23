<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractNamesRequest extends FormRequest
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
            'name.en' => 'nullable|sometimes|string|max:255',
            'name.ar' => 'required|string|max:255',
            "contract_type_id" => "required|exists:contract_types,id"
        ];
    }

    protected function update(): array
    {
        return [
            'name.en' => 'nullable|sometimes|string|max:255',
            'name.ar' => 'required|string|max:255',
            "contract_type_id" => "required|exists:contract_types,id"
        ];
    }

    public function messages(): array
    {
        return [
            // Title EN
            'name.en.required' => trns('English name is required'),
            'name.en.string' => trns('English name must be a string'),
            'name.en.max' => trns('English name must not exceed 255 characters'),

            // Title AR
            'name.ar.required' => trns('Arabic name is required'),
            'name.ar.string' => trns('Arabic name must be a string'),
            'name.ar.max' => trns('Arabic name must not exceed 255 characters'),
        ];
    }
}
