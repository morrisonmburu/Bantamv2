<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveApplicationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "leave_type" => "required",
            "start_date" => "bail|required",
            "no_of_days" => 'bail|required',
            "end_date" => 'bail|required',
            "return_date" => 'required',
        ];
    }
}
