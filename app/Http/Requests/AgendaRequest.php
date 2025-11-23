<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendaRequest extends FormRequest
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
                'name.ar'         => 'required|string|max:255',
                'name.en'         => 'nullable|sometimes|string|max:255',
                'description.ar'  => 'required|string',
                'description.en'  => 'nullable|sometimes|string',
                'date'            => 'required',
                'meet_id'         => 'nullable|exists:meetings,id', // ✅ added
                'from_meet'         => 'nullable|sometimes', // ✅ added
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name.ar'         => 'sometimes|required|string|max:255',
                'name.en'         => 'nullable|sometimes|required|string|max:255',
                'description.ar'  => 'nullable|sometimes|string',
                'description.en'  => 'nullable|sometimes|string',
                'date'            => 'sometimes|required',
                'meet_id'         => 'nullable|exists:meetings,id', // ✅ added
                'from_meet'         => 'nullable|sometimes', // ✅ added
            ];
        }

        return [];
    }


    public function messages()
    {
        return [
            'name.ar.required' => trns('The Arabic name is required.'),
            'name.en.required' => trns('The English name is required.'),
            'name.ar.string'   => trns('The Arabic name must be a string.'),
            'name.en.string'   => trns('The English name must be a string.'),
            'name.ar.max'      => trns('The Arabic name may not be greater than 255 characters.'),
            'name.en.max'      => trns('The English name may not be greater than 255 characters.'),
            'description.string' => trns('The description must be a string.'),
            'date.required'    => trns('The date field is required.'), // 👈 new message
            'date.date'        => trns('The date is not a valid date.'), // 👈 new message
        ];
    }
}
