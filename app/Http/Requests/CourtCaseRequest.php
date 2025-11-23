<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourtCaseRequest extends FormRequest
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
                'case_number'         => 'required|integer|unique:court_cases,case_number',
                'case_type_id'        => 'required|exists:case_types,id',
                'judiciaty_type_id'   => 'required|exists:judiciaty_types,id',
                'association_id'      => 'required|exists:associations,id',
                'owner_id'            => 'required|exists:users,id',
                'unit_id'             => 'required|exists:units,id',
                'case_date'           => 'required|date',
                'judiciaty_date'      => 'nullable|date|after_or_equal:case_date',
                'case_price'          => 'required|numeric|min:0',
                'topic'               => 'required|string|max:255',
                'description'         => 'nullable|string',
                'files'               => 'nullable|sometimes',
                'singlePage'          => 'nullable|sometimes',
            ];
        } else {
            return [
                'case_number'         => 'required|integer|unique:court_cases,case_number,' . $this->route('court_case'),
                'case_type_id'        => 'required|exists:case_types,id',
                'judiciaty_type_id'   => 'required|exists:judiciaty_types,id',
                'association_id'      => 'required|exists:associations,id',
                'owner_id'            => 'required|exists:users,id',
                'unit_id'             => 'required|exists:units,id',
                'case_date'           => 'required|date',
                'judiciaty_date'      => 'nullable|date|after_or_equal:case_date',
                'case_price'          => 'required|numeric|min:0',
                'topic'               => 'required|string|max:255',
                'description'         => 'nullable|string',
                'new_files'           => 'nullable|sometimes',
                'existing_files'      => 'nullable|sometimes',
            ];
        }
    }
}
