<?php

namespace App\Http\Controllers;

use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\Http\Resources\EmployeeLeaveApplicationCollection;
use App\Http\Resources\LeaveApplicationResource;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveApplicationRequest as LeaveRequest;
use App\Employee;
use Illuminate\Support\Facades\Auth;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection(EmployeeLeaveApplication::all());
        }
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveRequest $request, EmployeeLeaveApplication $LeaveApplication)
    {
        $data = [
            "Employee_No" => Auth::user()->Employee_Record->No,
            "Leave_Code" => $request->leave_code,
            "Start_Date" => $request->start_date,
            "Days_Applied" => $request->no_of_days,
            "Application_Code" => uniqid()
        ];
        $LeaveApplication->fill($data);
        try {
            if ($LeaveApplication->save()) {
                return response('Success', 200)->header('Content-Type', 'text/plain');
            }
        } catch (\Exception $e) {
            return response('Error occurred while creating leave application :' . $e->getMessage(), 500)->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        if ($request->is('api*')) {
            return new LeaveApplicationResource($employeeLeaveApplication);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    public function EmployeeLeaveApplications(Employee $employee, Request $request)
    {
        if ($request->is('api*')) {
            return new LeaveApplicationResource($employee->Employee_leave_applications);
        }
    }

    public function requests(Request $request){
        $requests = Emp;

        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection($requests);
        }
    }

    public function calculateLeaveDates(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'no_of_days' => 'required|numeric',
            'leave_code' => 'required'
        ]);

        $manager = new NavSyncManager();

        try {
            $result = $manager->calculateLeaveDates(
                $validatedData['leave_code'],
                Auth::user()->Employee_Record->No,
                Auth::user()->Employee_Record->_x003C_Base_Calendar_cODE_x003E_,
                $validatedData['start_date'],
                $validatedData['no_of_days']
            );
        } catch (\Exception $e) {
            if ($e->getCode() == NavSyncManager::$NAV_HTTP_ERROR_CODE)
                abort(400, $e->getMessage());
            else {
                throw $e;
            }
        }

        return json_encode((array)$result);

    }
}
