<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            return $this->update();
        }

        return $this->store();
    }

    protected function store(): array
    {
        return [
            // Foreign keys
            'contract_type_id'         => 'required|exists:contract_types,id',
            'contract_name_id'         => 'required|exists:contract_names,id',
            'date'                     => 'required|date',
            'contract_type' => 'required|string|in:general,association,owners_with_owner,owners_with_partner',


            // Only required if contract_type is association
            'association_id' => 'nullable|exists:associations,id',
            'user_association_id' => 'nullable|exists:associations,id',
            'user_partner_association_id' => 'nullable|exists:associations,id',
            'association_admin_id' => 'sometimes|nullable|exists:admins,id',
            'first_association_user_id' => 'sometimes|nullable|exists:users,id',
            'second_association_user_id' => 'sometimes|nullable|exists:users,id',

            // Only required if contract_type is owners
            'owners_id' => 'nullable|array',
            'owners_id.*' => 'exists:users,id', // each selected user must exist

            // Optional users field for general type (readonly)
            'users_id' => 'nullable|array',
            'users_id.*' => 'exists:users,id',

            'contract_location_id' => 'required',
            'contract_location'    => 'nullable|required_if:contract_location_id,other',

            // Terms (many to many)
            'contract_term_id'   => 'nullable|array',
            'contract_term_id.*' => 'nullable|exists:contract_terms,id',


            // Optional fields
            'contract_address'         => 'nullable|string|max:500',
            'introduction'             => 'required|string',

            // Parties
            'contract_party_id'        => 'sometimes|nullable|exists:contract_parties,id',
            'contract_party_two_id'    => 'sometimes|nullable|exists:contract_parties,id',

            // Party details
            'party_name'               => 'required|array|min:2',
            'party_name.*'             => 'required|string|max:255',

            'party_nation_id'          => 'required|array|min:2',
            'party_nation_id.*'        => 'required|string',

            'party_phone'              => 'required|array|min:2',
            'party_phone.*'            => 'nullable|string|max:20',

            'party_email'              => 'nullable|array|min:2',
            'party_email.*'            => 'nullable|email',

            'party_address'            => 'required|array|min:2',
            'party_address.*'          => 'required|string|max:500',

            "contract_location"        => "sometimes|nullable"
        ];
    }

    protected function update(): array
    {
        return [
            // نفس الحقول الأساسية زي store
            'contract_type_id'         => 'required|exists:contract_types,id',
            'contract_name_id'         => 'required|exists:contract_names,id',
            'date'                     => 'required|date',

            'contract_type' => 'required|string|in:general,association,owners_with_owner,owners_with_partner',


            'association_id' => 'nullable|exists:associations,id',

            'owners_id' => 'nullable|array',
            'owners_id.*' => 'exists:users,id',

            'users_id' => 'nullable|array',
            'users_id.*' => 'exists:users,id',


            'contract_location_id' => 'required',
            'contract_location'    => 'nullable|required_if:contract_location_id,other',

            // Terms (ممكن المستخدم يسيبها فاضية في التحديث)
            'contract_term_id'         => 'nullable|array',
            'contract_term_id.*'       => 'exists:contract_terms,id',

            // Optional fields
            'contract_address'         => 'nullable|string|max:500',
            'introduction'             => 'required|string',

            // Parties
            'contract_party_id'  => 'sometimes|nullable|exists:contract_parties,id',
            'contract_party_two_id' => 'sometimes|nullable|exists:contract_parties,id',

            // Party details (first)
            'party_name.first'         => 'nullable|string|max:255',
            'party_nation_id.first'    => 'nullable|string',
            'party_phone.first'        => 'nullable|string|max:20',
            'party_email.first'        => 'nullable|email',
            'party_address.first'      => 'nullable|string|max:500',

            // Party details (second)
            'party_name.second'        => 'nullable|string|max:255',
            'party_nation_id.second'   => 'nullable|string',
            'party_phone.second'       => 'nullable|string|max:20',
            'party_email.second'       => 'nullable|email',
            'party_address.second'     => 'nullable|string|max:500',


        ];
    }

    public function messages(): array
    {
        return [
            'contract_type_id.required'     => trns('Contract type is required'),
            'contract_type_id.exists'       => trns('Selected contract type is invalid'),

            'contract_name_id.required'     => trns('Contract name is required'),
            'contract_name_id.exists'       => trns('Selected contract name is invalid'),

            'date.required'                 => trns('Contract date is required'),
            'date.date'                     => trns('Contract date must be a valid date'),

            'contract_location_id.required' => trns('Contract location is required'),
            'contract_location_id.exists'   => trns('Selected contract location is invalid'),

            'contract_term_id.array'        => trns('Contract terms must be an array'),
            'contract_term_id.*.exists'     => trns('One or more selected contract terms are invalid'),

            'contract_first_party_id.required' => trns('First party is required'),
            'contract_first_party_id.exists'   => trns('Selected first party is invalid'),

            'contract_second_party_id.required' => trns('Second party is required'),
            'contract_second_party_id.exists'  => trns('Selected second party is invalid'),
        ];
    }
}
