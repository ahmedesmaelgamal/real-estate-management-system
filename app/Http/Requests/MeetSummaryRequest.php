<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetSummaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'title.ar' => 'required|string|max:255',
                'title.en' => 'nullable|sometimes|string|max:255',
                'description.ar' => 'nullable|string',
                'description.en' => 'nullable|sometimes|string',
                'owner_id' => 'sometimes|nullable|exists:users,id',
                'user_id' => 'sometimes|nullable|exists:users,id',
                "meet_id" => "sometimes|nullable",
                "date" => "required",
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'title.ar' => 'sometimes|required|string|max:255',
                'title.en' => 'nullable|sometimes|required|string|max:255',
                'description.ar' => 'nullable|string',
                'description.en' => 'nullable|sometimes|string',
                'owner_id' => 'sometimes|required|exists:users,id',
                'user_id' => 'sometimes|nullable|exists:users,id',
                "date" => "nullable",
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
            'description.string' => trns('The description must be a string.'),
            'owner_id.required' => trns('The owner field is required.'),
            'owner_id.exists' => trns('The selected owner is invalid.'),
        ];

    }
}
