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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'position_id'       => 'required|exists:positions,id',
            'birth_city_id'     => 'required|exists:cities,id',
            'manager_id'        => 'nullable|exists:employees,id',
            'user_id'           => 'nullable|exists:users,id',
            'area_id'           => 'required|exists:areas,id',
            'first_name'        => 'required|max:50',
            'last_name'         => 'required|max:100',
            'identification'    => 'required|integer',
         ];
    }
}
