<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'real_state_id' => 'required|exists:real_state,id',
            'association_id' => 'required|exists:associations,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'percentages' => 'required|array',
            'percentages.*' => 'required',
            'unit_number' => 'required',
            'description' => 'nullable|string',
            'space' => 'required|integer',
            'unit_code' => 'required|integer',
            'floor_count' => 'required|integer',
            'bathrooms_count' => 'required|integer',
            'bedrooms_count' => 'required|integer',
            'northern_border' => 'required|integer',
            'southern_border' => 'required|integer',
            'eastern_border' => 'required|integer',
            'western_border' => 'required|integer',
            'stop_reason' => 'nullable|string',
            'images' => 'nullable',
            'attachment' => 'nullable',
            "singlePageCreate" => "nullable",

            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|integer',
            'existing_files' => 'nullable|array',
            'existing_files.*' => 'nullable|integer',
            'new_images' => 'nullable|array',
            'new_images.*' => 'nullable',
            'new_files' => 'nullable|array',
            'new_files.*' => 'nullable|file|max:5120',




            'electric_account_number' => 'required|array',
            'electric_account_number.*' => 'required|max:255',
            'electric_meter_number' => 'required|array',
            'electric_meter_number.*' => 'required|max:255',
            'electric_subscription_number' => 'required|array',
            'electric_subscription_number.*' => 'required|max:255',
            'electric_name' => 'required|array',
            'electric_name.*' => 'required|max:255',

            'water_account_number' => 'required|array',
            'water_account_number.*' => 'required|max:255',

            'water_meter_number' => 'required|array',
            'water_meter_number.*' => 'required|max:255',
            'water_name' => 'required|array',
            'water_name.*' => 'required|max:255',
        ];
    }

    protected function update(): array
    {
        return [
            'real_state_id' => 'nullable|exists:real_state,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'nullable|exists:users,id',
            'percentages' => 'required|array',
            'percentages.*' => 'required',
            'unit_number' => 'nullable',
            'description' => 'nullable|string',
            'space' => 'nullable|integer',
            'unit_code' => 'nullable|integer',
            'floor_count' => 'nullable|integer',
            'bathrooms_count' => 'nullable|integer',
            'bedrooms_count' => 'nullable|integer',
            'northern_border' => 'nullable|integer',
            'southern_border' => 'nullable|integer',
            'eastern_border' => 'nullable|integer',
            'western_border' => 'nullable|integer',
            'stop_reason' => 'nullable|string',
            'images' => 'nullable',
            'attachment' => 'nullable',
            "singlePageCreate" => "nullable",
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|integer',
            'existing_files' => 'nullable|array',
            'existing_files.*' => 'nullable|integer',
            'new_images' => 'nullable|array',
            'new_images.*' => 'nullable',
            'new_files' => 'nullable|array',
            'new_files.*' => 'nullable|file',


            'electric_account_number' => 'required|array',
            'electric_account_number.*' => 'required|max:255',
            'electric_meter_number' => 'required|array',
            'electric_meter_number.*' => 'required|max:255',
            'electric_subscription_number' => 'required|array',
            'electric_subscription_number.*' => 'required|max:255',
            'electric_name' => 'required|array',
            'electric_name.*' => 'required|max:255',

            'water_account_number' => 'required|array',
            'water_account_number.*' => 'required|max:255',

            'water_meter_number' => 'required|array',
            'water_meter_number.*' => 'required|max:255',
            'water_name' => 'required|array',
            'water_name.*' => 'required|max:255',
        ];
    }

    public function messages(): array
    {


        return [
            'real_state_id.exists' => trns('Real state ID must exist'),
            'user_ids.array' => trns('User IDs must be an array'),
            'user_ids.*.exists' => trns('Each user ID must exist'),
            'percentages.array' => trns('Percentages must be an array'),
            'percentages.*.exists' => trns('Each percentage must exist'),
            'description.string' => trns('Description must be a string'),
            'space.integer' => trns('Space must be an integer'),
            'unit_code.integer' => trns('Unit code must be an integer'),
            'floor_count.integer' => trns('Floor count must be an integer'),
            'bathrooms_count.integer' => trns('Bathrooms count must be an integer'),
            'bedrooms_count.integer' => trns('Bedrooms count must be an integer'),
            'northern_border.integer' => trns('Northern border must be an integer'),
            'southern_border.integer' => trns('Southern border must be an integer'),
            'eastern_border.integer' => trns('Eastern border must be an integer'),
            'western_border.integer' => trns('Western border must be an integer'),
            'stop_reason.string' => trns('Stop reason must be a string'),
            'existing_images.array' => trns('Existing images must be an array'),
            'existing_images.*.integer' => trns('Each existing image ID must be an integer'),
            'existing_files.array' => trns('Existing files must be an array'),
            'existing_files.*.integer' => trns('Each existing file ID must be an integer'),
            'new_images.array' => trns('New images must be an array'),
            'new_files.array' => trns('New files must be an array'),
            'new_files.*.file' => trns('Each new file must be a file'),
            'new_files.*.max' => trns('Each new file must not be larger than five megabytes'),
        ];
    }
}
