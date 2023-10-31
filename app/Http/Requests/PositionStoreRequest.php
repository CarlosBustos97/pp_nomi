<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionStoreRequest extends FormRequest
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
        return [
            'name'              => 'required|string',
            'identification'    => 'required|numeric|unique:employees,identification,except,id',
            'area_id'           => 'required|exists:areas,id',
            'position_id'       => 'required|exists:positions,id',
            'role_id'           => 'required|exists:roles,id',
            'manager_id'        => 'nullable|exists:employees,id'
        ];
    }

    public function messages(){
        return [
            'name'              => __('validation.required'),
            'identification'    => __('validation.required'),
            'identification'    => __('validation.unique'),
            'area_id'           => __('validation.required'),
            'area_id'           => __('validation.exists'),
            'position_id'       => __('validation.required'),
            'position_id'       => __('validation.exists'),
            'role_id'           => __('validation.required'),
            'role_id'           => __('validation.exists'),
            'manager_id'        => __('validation.exists'),
        ];
    }
}
