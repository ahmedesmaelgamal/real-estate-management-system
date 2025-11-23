<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseUpdateTypeRequest extends FormRequest
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
                'title.ar' => 'required|string|max:255',
                'title.en' => 'nullable|sometimes|string|max:255',
            ];
        } else {
            return [
                "title.ar" => "required|string|max:255",
                "title.en" => "nullable|sometimes|string|max:255",
            ];
        }
    }
}
