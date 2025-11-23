<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'title.ar' => 'required|string|max:255',
                'title.en' => 'nullable|sometimes|string|max:255',

                "meet_id" => "sometimes|nullable",
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'title.ar' => 'sometimes|required|string|max:255',
                'title.en' => 'nullable|sometimes|string|max:255',

            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'title.ar.required' => trns('The Arabic title is required.'),
            'title.en.required' => trns('The English title is required.'),
            'title.ar.string' => trns('The Arabic title must be a string.'),
            'title.en.string' => trns('The English title must be a string.'),
            'title.ar.max' => trns('The Arabic title may not be greater than 255 characters.'),
            'title.en.max' => trns('The English title may not be greater than 255 characters.'),

        ];

    }
}
