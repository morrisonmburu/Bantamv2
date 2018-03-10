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
            "Employee_No"=>"sometimes",
//            "Leave_Code"=>'required',
            "start_date"=>"required",
            "no_of_days"=>'Required',
        ];
    }
    public function messages()
    {
        return [
//            "Employee_No.required"=>"Employee No is blank",
//            "Leave_Code.required"=>"Leave code is blank",
            "start_date.required"=>"Start date is blank",
            "no_of_days.Required"=>"Approved days not specified"
        ];
    }
}
