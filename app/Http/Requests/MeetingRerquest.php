<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRerquest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Remove "other" from topic_id before validation
     */
    protected function prepareForValidation(): void
    {
        if (is_array($this->topic_id)) {
            // Remove the "other" value completely
            $filtered = array_filter($this->topic_id, fn($id) => $id !== 'other');
            $this->merge([
                'topic_id' => array_values($filtered),
            ]);
        }
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'association_id' => 'required|exists:associations,id',
                
                'owner_id'       => 'required|exists:admins,id',
                'agenda_id'      => 'required|array',
                'agenda_id.*'    => 'nullable|exists:agendas,id',
                'topic_id'       => 'sometimes|nullable|array',
                'topic_id.*'     => 'nullable|exists:topics,id',
                'date'           => 'required|date',
                'address'        => 'required|string|max:255',
                'users_id'       => 'required|array',
                'users_id.*'     => 'exists:users,id',
                'other_topic'    => 'sometimes|nullable|string|max:255',
                'topic'    => 'sometimes|nullable|string|max:255',
            ];
        } elseif ($this->isMethod('put')) {
            return [
                'association_id' => 'sometimes|nullable|exists:associations,id',
                
                'agenda_id'      => 'required|array',
                'agenda_id.*'    => 'nullable|exists:agendas,id',
                'owner_id'       => 'sometimes|required|exists:admins,id',
                'topic_id'       => 'sometimes|nullable|array',
                'topic_id.*'     => 'nullable|exists:topics,id',
                'date'           => 'sometimes|required|date',
                'address'        => 'sometimes|required|string|max:255',
                'users_id'       => 'sometimes|required|array',
                'users_id.*'     => 'exists:users,id',
                'other_topic'    => 'sometimes|nullable|string|max:255',
                'topic'    => 'sometimes|nullable|string|max:255',
            ];
        }

        return [];
    }


    public function messages()
    {
        return [
            'association_id.required' => trns('The association field is required.'),
            'association_id.exists'   => trns('The selected association is invalid.'),
            'meet_number.required'    => trns('The meeting number field is required.'),
            'meet_number.integer'     => trns('The meeting number must be an integer.'),
            'meet_number.unique'      => trns('This meeting number is already used.'),
            'agenda_id.required'      => trns('The agenda field is required.'),
            'agenda_id.exists'        => trns('The selected agenda is invalid.'),
            'owner_id.required'       => trns('The owner field is required.'),
            'owner_id.exists'         => trns('The selected owner is invalid.'),
            'topic_id.required'       => trns('The topic field is required.'),
            'topic_id.array'          => trns('The topic field must be an array.'),
            'topic_id.*.exists'       => trns('One or more selected topics are invalid.'),
            'date.required'           => trns('The date field is required.'),
            'date.date'               => trns('The date is not a valid date format.'),
            'address.required'        => trns('The address field is required.'),
            'address.string'          => trns('The address must be a string.'),
            'address.max'             => trns('The address may not be greater than 255 characters.'),
            'users_id.required'       => trns('The users field is required.'),
            'users_id.array'          => trns('The users field must be an array.'),
            'users_id.*.exists'       => trns('One or more selected users are invalid.'),
            'other_topic.string'      => trns('The other topic must be a valid text.'),
            'other_topic.max'         => trns('The other topic may not be greater than 255 characters.'),
        ];
    }
}
