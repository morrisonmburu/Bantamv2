<?php

namespace App\Http\Controllers;

use App\EmployeeLeaveAllocation;
use App\Http\Resources\EmployeeLeaveAllocationCollection;
use App\Http\Resources\LeaveAllocationResource;
use App\Http\Resources\LeaveTypeResource;
use App\LeaveType;
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
        $this->authorize('index', EmployeeLeaveAllocation::class);
        if ($request->is('api*')) {
            return new EmployeeLeaveAllocationCollection(EmployeeLeaveAllocation::all());
        }
    }

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
    public function show(EmployeeLeaveAllocation $leave_allocation, Request $request)
    {
        $this->authorize('view', $leave_allocation);
        if ($request->is('api*')) {
            return new LeaveAllocationResource($leave_allocation);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeLeaveAllocation $leave_allocation)
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
    public function update(Request $request, EmployeeLeaveAllocation $leave_allocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeLeaveAllocation $leave_allocation)
    {
        //
    }

    //Get current employee's leave allocations

    public function EmployeeLeaveAllocations(Employee $employee, Request $request){
        $this->authorize('employee', [EmployeeLeaveAllocation::class, $employee]);
        if ($request->is('api*')) {
            return new LeaveAllocationResource($employee->Employee_leave_allocations()->paginate());
        }
    }


        //Get current employee's leave types

        public function current_employee_leave_types( Request $request){
            $employee = $request->user()->Employee_Record;
//            $this->authorize('employee', [EmployeeLeaveAllocation::class, $employee]);
//            if ($request->is('api*')) {
//                return $employee->leave_types()->paginate();
//            }

            return new LeaveTypeResource(
                LeaveType::where(function ($query) use($employee){
                    $query->where('Gender', $employee->Gender);
                    $query->orWhere('Gender', 'Both');
                })->get()
            );
        }
}
