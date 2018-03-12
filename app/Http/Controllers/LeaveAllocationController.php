<?php

namespace App\Http\Controllers;

use App\EmployeeLeaveAllocation;
use App\Http\Resources\EmployeeLeaveAllocationCollection;
use App\Http\Resources\LeaveAllocationResource;
use Illuminate\Http\Request;
use App\Employee;

class LeaveAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->is('api*')) {
            return new EmployeeLeaveAllocationCollection(EmployeeLeaveAllocation::all());
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
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeLeaveAllocation $employeeLeaveAllocation, Request $request)
    {
        if ($request->is('api*')) {
            return new LeaveAllocationResource($employeeLeaveAllocation);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeLeaveAllocation $employeeLeaveAllocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeLeaveAllocation $employeeLeaveAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeLeaveAllocation $employeeLeaveAllocation)
    {
        //
    }

    //Get current employee's leave allocations

    public function EmployeeLeaveAllocations(Employee $employee, Request $request){
        if ($request->is('api*')) {
            return new LeaveAllocationResource($employee->Employee_leave_allocations);
        }
    }
}
