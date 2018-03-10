<?php

namespace App\Http\Controllers;

use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\Http\Resources\LeaveApplicationResource;
use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        //
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

    public function calculateLeaveDates(Request $request){
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'no_of_days' => 'required|decimal',
            'leave_code' => 'required'
        ]);

        $manager = new NavSyncManager();
        $result = $manager->calculateLeaveDates(
            $validatedData['leave_code'],
            Auth::user()->Employee_Record->No,
            Auth::user()->Employee_Record->Base_Calendar,
            $validatedData['start_date'],
            $validatedData['no_of_days']
        );

        return json_encode($result);

    }
}
