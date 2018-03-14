<?php

namespace App\Http\Resources;

use App\Employee;
use App\EmployeeLeaveApplication;
use Illuminate\Http\Resources\Json\ResourceCollection;
use MongoDB\Driver\Exception\ExecutionTimeoutException;

class ApprovalEntryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $arr =  parent::toArray($request);
        try{
            $arr["Employee_Details"]  = new EmployeeResource(Employee::where('No', $arr["Sender_ID"])->first());
            $arr["Application_Details"]  = new EmployeeLeaveApplicationResource(
                EmployeeLeaveApplication::where('Application_Code', $arr["Document_No"])->first());
        }
        catch (\Exception $e){

        }
        return $arr;
    }
}
