<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RealStateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod(method: 'PUT')) {
            return $this->update();
        } else {
            return $this->store();
        }
    }

    protected function store(): array
    {
        return [
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'association_id' => 'required|exists:associations,id',
            'name' => 'required|max:255',
            'real_state_number' => 'required',
            'street' => 'required|max:255',
            'space' => 'required|max:255',
            'part_number' => 'required|max:255',
            'bank_account_number' => 'required',
            'mint_number' => 'required|max:255',
            'mint_source' => 'required|max:255',
            'floor_count' => 'required',
            'elevator_count' => 'required',
            'building_type' => 'required',
            'building_year' => 'required',



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


            'northern_border' => 'required|max:255',
            'southern_border' => 'required|max:255',
            'eastern_border' => 'required|max:255',
            'western_border' => 'required|max:255',
            'status' => 'nullable',

            'lat' => 'required|numeric',
            'long' => 'required|numeric',

            "stop_reason" => "nullable|string",
            "flat_space" => "required|string",

            'images' => 'nullable',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'files' => 'nullable',
            'files.*' => 'nullable|file|max:5120',


            'submit_type' => 'nullable',

            "singlePage" => "nullable",
            'legal_ownership_id' => 'required_if:legal_ownership_other,null',
            'legal_ownership_other' => 'required_if:legal_ownership_id,null',
        ];
    }

    protected function update(): array
    {
        return [
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'association_id' => 'required',
            'name' => 'required|max:255',

            'street' => 'required|max:255',
            'space' => 'required|max:255',
            'part_number' => 'required|max:255',
            'bank_account_number' => 'required',
            'mint_number' => 'required|max:255',
            'mint_source' => 'required|max:255',
            'floor_count' => 'required',


            'elevator_count' => 'required',
            'building_year' => 'required',




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
            'water_name' => 'required|array',
            'water_name.*' => 'required|max:255',

            'water_meter_number' => 'required|array',
            'water_meter_number.*' => 'required|max:255',
            'northern_border' => 'required|max:255',
            'southern_border' => 'required|max:255',
            'eastern_border' => 'required|max:255',
            'western_border' => 'required|max:255',
            'status' => 'nullable',

            'lat' => 'required|numeric',
            'long' => 'required|numeric',

            "stop_reason" => "nullable|string",
            "flat_space" => "required|string",
            "building_type" => "required|string",

            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|integer',
            'existing_files' => 'nullable|array',
            'existing_files.*' => 'nullable|integer',
            'new_images' => 'nullable|array',
            'new_images.*' => 'nullable',
            'new_files' => 'nullable|array',
            'new_files.*' => 'nullable|file',

            "singlePage" => "nullable",
            'legal_ownership_id' => 'required_if:legal_ownership_other,null',
            'legal_ownership_other' => 'required_if:legal_ownership_id,null',
        ];
    }

    public function messages(): array
    {
        return [
            'legal_ownership_id' => trns('required'),
            'legal_ownership_other' => trns('required'),
            'logo.image' => trns('Logo must be an image'),
            'logo.mimes' => trns('Logo must be of type jpeg, png, jpg, gif, or svg'),
            'logo.max' => trns('Logo must not be larger than 2MB'),

            'association_id.required' => trns('Association is required'),
            'association_id.exists' => trns('Selected association does not exist'),

            'name.required' => trns('Name is required'),
            'name.max' => trns('Name may not exceed 255 characters'),

            'real_state_number.required' => trns('Real state number is required'),

            'street.required' => trns('Street is required'),
            'street.max' => trns('Street may not exceed 255 characters'),

            'space.required' => trns('Space is required'),
            'space.max' => trns('Space may not exceed 255 characters'),

            'part_number.required' => trns('Part number is required'),
            'part_number.max' => trns('Part number may not exceed 255 characters'),

            'bank_account_number.required' => trns('Bank account number is required'),
            'bank_account_number.max' => trns('Bank account number may not exceed 255 characters'),

            'mint_number.required' => trns('Mint number is required'),
            'mint_number.max' => trns('Mint number may not exceed 255 characters'),

            'mint_source.required' => trns('Mint source is required'),
            'mint_source.max' => trns('Mint source may not exceed 255 characters'),

            'floor_count.required' => trns('Floor count is required'),

            'elevator_count.required' => trns('Elevator count is required'),

            'building_type.required' => trns('Building type is required'),

            'building_year.required' => trns('Building year is required'),





            'northern_border.required' => trns('Northern border is required'),
            'northern_border.max' => trns('Northern border may not exceed 255 characters'),

            'southern_border.required' => trns('Southern border is required'),
            'southern_border.max' => trns('Southern border may not exceed 255 characters'),

            'eastern_border.required' => trns('Eastern border is required'),
            'eastern_border.max' => trns('Eastern border may not exceed 255 characters'),

            'western_border.required' => trns('Western border is required'),
            'western_border.max' => trns('Western border may not exceed 255 characters'),

            'lat.required' => trns('Latitude is required'),
            'lat.numeric' => trns('Latitude must be a number'),

            'long.required' => trns('Longitude is required'),
            'long.numeric' => trns('Longitude must be a number'),

            'stop_reason.string' => trns('Stop reason must be a string'),
            'flat_space.string' => trns('Flat space must be a string'),

            'images.*.image' => trns('Each image must be an image file'),
            'images.*.mimes' => trns('Each image must be of type jpeg, png, jpg, gif, or svg'),
            'images.*.max' => trns('Each image may not be larger than 2MB'),

            'files.*.file' => trns('Each file must be a valid file'),
            'files.*.max' => trns('Each file may not exceed 5MB'),

            'existing_images.array' => trns('Existing images must be an array'),
            'existing_images.*.integer' => trns('Each existing image must be an integer'),

            'existing_files.array' => trns('Existing files must be an array'),
            'existing_files.*.integer' => trns('Each existing file must be an integer'),

            'new_images.array' => trns('New images must be an array'),

            'new_files.array' => trns('New files must be an array'),
            'new_files.*.file' => trns('Each new file must be a valid file'),
        ];
    }
}
