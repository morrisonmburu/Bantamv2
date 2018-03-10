<?php

namespace App\Http\Controllers;

use App\EmployeeLeaveApplication;
use App\Http\Resources\LeaveApplicationResource;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveApplicationRequest as LeaveRequest;
use App\Employee;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveRequest $request,EmployeeLeaveApplication $LeaveApplication)
    {
        $data = [
                "Employee_No"=>$request->Employee_No,
                "Leave_Period"=>$request->Leave_Period,
                "Leave_Code"=>$request->Leave_Code,
                "Approved_Start_Date"=>$request->start_date,
                "Approved_Days"=>$request->no_of_days,
                "Approved_End_Date"=>$request->end_date,
                "Approved_Return_Date"=>$request->return_date
            ];
        try{
            if ($LeaveApplication->save($data)){
                return response('Success', 200)->header('Content-Type', 'text/plain');
            }
        }catch (\Exception $e){
            return  response('Error occurred while creating leave application :'.$e->getMessage(), 500)->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    public function EmployeeLeaveApplications(Employee $employee, Request $request){
        if ($request->is('api*')){
            return new LeaveApplicationResource($employee->Employee_leave_applications);
        }
    }
}
