<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElectricsRequest extends FormRequest
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



        $rules = [
            'electric_name' => 'required',
            'electric_account_number' => 'required',
            'electric_subscription_number' => 'required',
            'electric_meter_number' => 'required',
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
        $rules = [
            'electric_name' => 'required',
            'electric_account_number' => 'required',
            'electric_subscription_number' => 'required',
            'electric_meter_number' => 'required',
        ];

       

        return $rules;
    }

    public function messages(): array
    {
        return [
            'real_state_id.required' => trns('real_state_required'),
            'real_state_id.exists' => trns('real_state_exists'),
            'electric_name.required' => trns('electric_name_required'),
            'electric_account_number.required' => trns('electric_account_number_required'),
            'electric_subscription_number.required' => trns('electric_subscription_number_required'),
            'electric_meter_number.required' => trns('electric_meter_number_required'),
        ];
    }
}
