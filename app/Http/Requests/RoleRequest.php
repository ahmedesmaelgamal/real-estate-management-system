<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'guard_name' => 'required:in:admin,web',
            'permissions' => 'required|array',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required',
            'guard_name' => 'required:in:admin,web',
            'permissions' => 'required|array',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => trns('Name is required'),

            'guard_name.required' => trns('Guard name is required'),
            'guard_name.in' => trns('Guard name must be either admin or web'),

            'permissions.required' => trns('Permissions are required'),
            'permissions.array' => trns('Permissions must be an array'),
        ];
    }

}
