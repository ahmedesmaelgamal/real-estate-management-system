<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->has('email')) {
            $this->merge([
                'email' => trim($this->email).'@edarat365.com',
            ]);
        }
        if (request()->isMethod('put')) {
            return $this->update();
        } else {
            return $this->store();
        }
    }

    protected function store(): array
    {
        return [
            'name' => 'required',
            'role_id' => 'required|exists:roles,id',
            'code' => 'required|unique:admins,code',
            'national_id' => 'required|numeric|unique:admins,national_id|digits:10',
            'email' => 'required',
            'phone' => 'required',
            'email' => [
                'required',
                'email',
                'unique:admins,email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@edarat365.com')) {
                        $fail(trns('Email must end with @edarat365.com'));
                    }
                },
            ],
            'singlePageCreate' => 'nullable',
            'submit_type' => 'required_ with:singlePageCreate',


        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required',
            'role_id' => 'required|exists:roles,id',
            'national_id' => 'required|numeric|digits:10|unique:admins,national_id,'  . $this->admin,
            'email' => 'required',
            'phone' => 'required|unique:admins,phone,'  . $this->admin,
            "singlePageCreate" => "nullable",
        ];
    }

    public function messages(): array
    {
        return [
            // Name
            'name.required' => trns('Name is required'),

            // Role
            'role_id.required' => trns('Role is required'),
            'role_id.exists' => trns('Selected role does not exist'),

            // Code
            'code.required' => trns('Code is required'),
            'code.unique' => trns('This code is already taken'),

            // National ID
            'national_id.required' => trns('National ID is required'),
            'national_id.numeric' => trns('National ID must be numeric'),
            'national_id.digits' => trns('National ID must be exactly 10 digits'),
            'national_id.unique' => trns('National ID must be unique'),

            // Email
            'email.required' => trns('Email is required'),

            // Phone
            'phone.required' => trns('Phone number is required'),
            'phone.unique' => trns('Phone number must be unique'),

            // Submit Type (conditional)
            'submit_type.required_with' => trns('Submit type is required when single page create is present'),
        ];
    }

}
