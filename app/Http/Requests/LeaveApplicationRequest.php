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
            "Employee_No"=>"required",
            "Leave_Code"=>'required',
            "Approved_Start_Date"=>"required",
            "Approved_Days"=>'Required',
        ];
    }
    public function messages()
    {
        return [
            "Employee_No.required"=>"Employee No is blank",
            "Leave_Code.required"=>"Leave code is blank",
            "Approved_Start_Date.required"=>"Start date is blank",
            "Approved_Days.Required"=>"Approved days not specified"
        ];
    }
}
