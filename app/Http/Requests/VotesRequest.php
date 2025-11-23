<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VotesRequest extends FormRequest
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
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->update();
        } else {
            return $this->store();
        }
    }

    public function store(): array
    {
        return [
            // العناوين والوصف باللغتين
            'title.ar'        => 'required|string|max:255',
            'title.en'        => 'nullable|sometimes|string|max:255',
            'description.ar'  => 'nullable|string',
            'description.en'  => 'nullable|sometimes|string',

            // باقي الحقول
            'association_id'   => 'required|exists:associations,id',
            'start_date'       => 'required|date|before_or_equal:end_date|after_or_equal:today',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'vote_percentage'  => 'required|numeric|min:0|max:100',
            'audience_number'  => 'required|numeric',
        ];
    }

    public function update(): array
    {
        return [
            'title.ar'        => 'sometimes|nullable|string|max:255',
            'title.en'        => 'sometimes|nullable|string|max:255',
            'description.ar'  => 'sometimes|nullable|string',
            'description.en'  => 'sometimes|nullable|string',

            'association_id'   => 'sometimes|nullable|exists:associations,id',
            'start_date'       => 'sometimes|nullable|date|before_or_equal:end_date|after_or_equal:today',
            'end_date'         => 'sometimes|nullable|date|after_or_equal:start_date',
            'vote_percentage'  => 'sometimes|nullable|numeric|min:0|max:100',
            'audience_number'  => 'sometimes|nullable|numeric',
        ];
    }

    /**
     * Custom messages (optional).
     */
    public function messages(): array
    {
        return [
            // العناوين والوصف
            'title_ar.required'       => trns('Arabic title is required.'),
            'title_en.required'       => trns('English title is required.'),
            'title_ar.max'            => trns('Arabic title may not be greater than 255 characters.'),
            'title_en.max'            => trns('English title may not be greater than 255 characters.'),

            // باقي الحقول
            'association_id.required'  => trns('Association is required.'),
            'association_id.exists'    => trns('Selected association does not exist.'),
            'audience_number.required' => trns('Audience number is required.'),
            'audience_number.numeric'  => trns('Audience number must be a valid number.'),
            'start_date.before_or_equal' => trns('Start date must be before or equal to end date.'),
            'end_date.after_or_equal'    => trns('End date must be after or equal to start date.'),
            'vote_percentage.max'      => trns('Vote percentage cannot be greater than 100.'),
        ];
    }
}
