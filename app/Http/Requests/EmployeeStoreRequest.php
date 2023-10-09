<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id'                => 'nullable|exists:employees,id',
            'name'              => 'required|string',
            'identification'    => 'required|numeric|unique:employees,identification,except,id',
            'cellphone'         => 'required|string',
            'city_id'           => 'required|exists:cities,id',
            'department_id'     => 'required|exists:departments,id',
            'address'           => 'required|string'
         ];
    }

    public function messages(){
        return [
            'id'                => __('validation.exists'),
            'name'              => __('validation.required'),
            'identification'    => __('validation.required'),
            'identification'    => __('validation.unique'),
            'cellphone'         => __('validation.required'),
            'city_id'           => __('validation.required'),
            'city_id'           => __('validation.exists'),
            'department_id'     => __('validation.required'),
            'department_id'     => __('validation.exists'),
        ];
    }
}
