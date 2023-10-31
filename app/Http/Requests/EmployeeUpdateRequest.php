<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'name'              => 'required|string',
            'identification'    => 'required|numeric|exists:employees,identification',
            'cellphone'         => 'required|string',
            'birth_city_id'     => 'required|exists:cities,id',
            'address'           => 'required|string'
         ];
    }

    public function messages(){
        return [
            'name'              => __('validation.required'),
            'identification'    => __('validation.required'),
            'identification'    => __('validation.exists'),
            'cellphone'         => __('validation.required'),
            'birth_city_id'     => __('validation.required'),
            'birth_city_id'     => __('validation.exists'),
        ];
    }
}
