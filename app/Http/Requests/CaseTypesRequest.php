<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseTypesRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        if ($this->isMethod("post")) {
            return [
                'title.ar' => 'required|string|max:255',
                'title.en' => 'nullable|sometimes|string|max:255',
            ];
        }else{
            return [
                "title.ar" => "required|string|max:255",
                "title.en" => "nullable|sometimes|string|max:255",
            ];
        }
    }
}
