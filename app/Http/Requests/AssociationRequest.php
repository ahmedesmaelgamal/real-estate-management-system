<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssociationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('put')) {
            return $this->update();
        } else {
            return $this->store();
        }
    }

    protected function store(): array
    {
        return [
            'name' => 'required|array',
            'name.en' => 'nullable|sometimes|string|max:255',
            'name.ar' => 'required|string|max:255',
            'number' => 'required|integer',
            'approval_date' => 'required|date',
            'establish_date' => 'required|date',
            'due_date' => 'required|date',
            'unified_number' => 'required|integer',
            'establish_number' => 'required|numeric',
            'status' => 'nullable',
            'interception_reason' => 'nullable|string|max:255',
            'association_manager_id' => 'nullable',
            'appointment_start_date' => 'required|date',
            'appointment_end_date' => 'required|date|after:appointment_start_date',
            'monthly_fees' => 'required|numeric',
            'is_commission' => 'boolean',
            'commission_name' => 'nullable|string|max:255|required_if:is_commission,1',
            'commission_type' => 'nullable|boolean|required_if:is_commission,1',
            'commission_percentage' => 'nullable|required_if:is_commission,1|between:0,100',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'logo' => 'nullable|',
            "images" => "nullable",
            "files" => "nullable",
            "singlePageCreate" => "nullable",
            'submit_type' => 'nullable',
            'association_model_id'=>'nullable|exists:association_models,id',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required',
            'name.en' => 'nullable|sometimes|string|max:255',
            'name.ar' => 'required|string|max:255',
            'number' => 'required|integer',
            // 'unit_count' => 'required|integer',
            // 'real_state_count' => 'nullable|integer',
            'approval_date' => 'required|date',
            'establish_date' => 'required|date',
            'due_date' => 'required|date',
            'unified_number' => 'required|integer',
            'establish_number' => 'required|numeric',
            'status' => 'nullable',
            'interception_reason' => 'nullable|string|max:255',
            'association_manager_id' => 'nullable',
            'appointment_start_date' => 'nullable|date',
            'appointment_end_date' => 'nullable|date|after:appointment_start_date',
            'monthly_fees' => 'nullable|numeric',
            'is_commission' => 'boolean',
            'commission_name' => 'nullable|string|max:255|required_if:is_commission,1',
            'commission_type' => 'nullable|boolean|required_if:is_commission,1',
            'commission_percentage' => 'nullable|required_if:is_commission,1|between:0,100',
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
            'logo' => 'nullable',
            "images" => "nullable",
            "files" => "nullable",
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|integer',
            'existing_files' => 'nullable|array',
            'existing_files.*' => 'nullable|integer',
            'new_images' => 'nullable|array',
            'new_images.*' => 'nullable',
            'new_files' => 'nullable|array',
            'new_files.*' => 'nullable|file|max:5120',
            "singlePageCreate" => "nullable",
            'association_model_id'=>'nullable|exists:association_models,id',

        ];
    }



    public function messages(): array
    {
        return [
            'name.required' => trns('Name is required'),
            'number.required' => trns('Number is required'),
            'number.integer' => trns('Number must be an integer'),

            'approval_date.required' => trns('Approval date is required'),
            'approval_date.date' => trns('Approval date must be a valid date'),

            'establish_date.required' => trns('Establish date is required'),
            'establish_date.date' => trns('Establish date must be a valid date'),

            'due_date.required' => trns('Due date is required'),
            'due_date.date' => trns('Due date must be a valid date'),

            'unified_number.required' => trns('Unified number is required'),
            'unified_number.integer' => trns('Unified number must be an integer'),

            'establish_number.required' => trns('Establish number is required'),
            'establish_number.numeric' => trns('Establish number must be numeric'),

            'interception_reason.string' => trns('Interception reason must be a string'),
            'interception_reason.max' => trns('Interception reason may not be greater than 255 characters'),

            'association_manager_id.exists' => trns('Selected manager does not exist'),

            'appointment_start_date.date' => trns('Appointment start date must be a valid date'),
            'appointment_end_date.date' => trns('Appointment end date must be a valid date'),
            'appointment_end_date.after' => trns('Appointment end date must be after the start date'),

            'monthly_fees.numeric' => trns('Monthly fees must be numeric'),

            'is_commission.boolean' => trns('Is commission must be true or false'),

            'commission_name.required_if' => trns('Commission name is required when commission is active'),
            'commission_name.string' => trns('Commission name must be a string'),
            'commission_name.max' => trns('Commission name may not be greater than 255 characters'),

            'commission_type.required_if' => trns('Commission type is required when commission is active'),
            'commission_type.boolean' => trns('Commission type must be true or false'),

            'commission_percentage.required_if' => trns('Commission percentage is required when commission is active'),
            'commission_percentage.between' => trns('Commission percentage must be between 0 and 100'),

            'lat.numeric' => trns('Latitude must be numeric'),
            'long.numeric' => trns('Longitude must be numeric'),

            'existing_images.array' => trns('Existing images must be an array'),
            'existing_images.*.integer' => trns('Each existing image ID must be an integer'),

            'existing_files.array' => trns('Existing files must be an array'),
            'existing_files.*.integer' => trns('Each existing file ID must be an integer'),

            'new_images.array' => trns('New images must be an array'),

            'new_files.array' => trns('New files must be an array'),
            'new_files.*.file' => trns('Each new file must be a valid file'),
            'new_files.*.max' => trns('Each new file may not be larger than 5MB'),

            'association_model_id.exists' => trns('Selected association model does not exist'),
        ];
    }

}
