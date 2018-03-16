<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeApprover;
use App\Http\Resources\EmployeeApproverResource;
use Illuminate\Http\Request;

class EmployeeApproverController extends Controller
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
     * @param  \App\EmployeeApprover  $employeeApprover
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeApprover $employeeApprover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeApprover  $employeeApprover
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeApprover $employeeApprover)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeApprover  $employeeApprover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeApprover $employeeApprover)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeApprover  $employeeApprover
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeApprover $employeeApprover)
    {
        //
    }

    public function employee_approvers(Request $request, Employee $employee){
        if($request->is('api*')) {
            return EmployeeApproverResource::collection($employee->approvers()->paginate());
        }
    }

    public  function approvers(Request $request){
        if($request->is('api*')) {
            return EmployeeApproverResource::collection($request->user()->Employee_Record->approvers()->paginate());
        }
    }
}
