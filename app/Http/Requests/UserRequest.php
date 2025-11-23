<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->isMethod('put') ? $this->updateRules() : $this->storeRules();
    }

    /**
     * Common rules for both store and update.
     */
    protected function commonRules(): array
    {
        return [
            'name' => 'required|string',
            'singlePageCreate' => 'nullable',
            'submit_type' => 'nullable',
        ];
    }

    /**
     * Rules for storing a new user.
     */
    protected function storeRules(): array
    {
        return array_merge($this->commonRules(), [
            'email' => 'required|email|unique:users,email',
            'status' => 'required|boolean',
            'phone' => 'required|unique:users,phone|min:10',
            'national_id' => 'required|numeric|unique:users,national_id|digits:10',
        ]);
    }

    /**
     * Rules for updating an existing user.
     */
    protected function updateRules(): array
    {
        $userId = $this->route('user') ?? $this->id;

        return array_merge($this->commonRules(), [
            'email' => 'required|email',
            'status' => 'required|boolean',
            'phone' => 'required|unique:users,phone,' . $userId,
            'national_id' => 'required|numeric|digits:10|unique:users,national_id,' . $userId,
        ]);
    }

    public function messages()
    {
        return [
            'name.required' => trns('Name is required.'),
            'email.required' => trns('Email is required.'),
            'email.email' => trns('Email is not valid.'),
            'email.unique' => trns('Email already exists.'),
            'phone.required' => trns('Phone is required.'),
            'phone.unique' => trns('Phone already exists.'),
            'national_id.required' => trns('National ID is required.'),
            'national_id.numeric' => trns('National ID must be a number.'),
            'national_id.unique' => trns('National ID already exists.'),
            'password.required' => trns('Password is required.'),
            'password.string' => trns('Password is not valid.'),
            'password_confirmation.required' => trns('Confirm Password is required.'),
            'password_confirmation.string' => trns('Confirm Password is not valid.'),
            'password_confirmation.same' => trns('Confirm Password is not valid.'),
        ];
    }
}
