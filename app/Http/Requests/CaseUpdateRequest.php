<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseUpdateRequest extends FormRequest
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
        if ($this->isMethod("post")) {
            return [
                'title' => ['required', 'array'],
                'title.*' => ['required', 'string', 'max:255'],
                
                'court_cases_id' => ['required', 'exists:court_cases,id'],
                'case_update_type_id' => ['required', 'exists:case_update_types,id'],

                'files'         => 'nullable|sometimes',
                
                'end_date' => ['nullable', 'date'],
                'description' => ['nullable', 'string'],
            ];
        } else {
            return [
                'title' => ['required', 'array'],
                'title.*' => ['required', 'string', 'max:255'],
                
                'court_cases_id' => ['required', 'exists:court_cases,id'],
                'case_update_type_id' => ['required', 'exists:case_update_types,id'],
                
                'end_date' => ['nullable', 'date'],
                'description' => ['nullable', 'string'],
            ];
        }
    }
}
