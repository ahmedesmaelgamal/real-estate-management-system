<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WatersRequest extends FormRequest
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
        if ($this->isMethod('put')) {
            return $this->update();
        } else {
            return $this->store();
        }
    }

    protected function store(): array
    {
        $rules = [
            'water_name' => 'required|array',
            'water_name.*' => 'required|string|max:255',

            'water_account_number' => 'required|array',
            'water_account_number.*' => 'required|numeric',

            'water_meter_number' => 'required|array',
            'water_meter_number.*' => 'required|numeric',
        ];

        if ($this->has('real_state_id')) {
            $rules['real_state_id'] = 'required|exists:real_state,id';
        } else {
            $rules['unit_id'] = 'required|exists:units,id';
        }

        return $rules;
    }

    protected function update(): array
    {
        // Keep the same rules for update
        return $this->store();
    }

    public function messages(): array
    {
        return [
            'real_state_id.required' => trns('real_state_required'),
            'real_state_id.exists' => trns('real_state_exists'),

            'water_name.required' => trns('water_name_required'),
            'water_name.array' => trns('water_name_must_be_array'),
            'water_name.*.required' => trns('water_name_required'),

            'water_account_number.required' => trns('water_account_number_required'),
            'water_account_number.array' => trns('water_account_number_must_be_array'),
            'water_account_number.*.required' => trns('water_account_number_required'),

            'water_meter_number.required' => trns('water_meter_number_required'),
            'water_meter_number.array' => trns('water_meter_number_must_be_array'),
            'water_meter_number.*.required' => trns('water_meter_number_required'),
        ];
    }
}
