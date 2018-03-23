<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeaveTypeResource;
use App\LeaveType;
use Illuminate\Http\Request;
use App\Employee;

class LeaveTypeController extends Controller
{
    public function index()
    {
        return new LeaveTypeResource(LeaveType::all());
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
     * @param  \App\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveType $leaveType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveType $leaveType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveType $leaveType)
    {
        //
    }

    public function LeaveTypes(Employee $employee){
//        return new LeaveTypeResource($employee->LeaveTypes);
        return new LeaveTypeResource(
            LeaveType::where(function ($query) use($employee){
                $query->where('Gender', $employee->Gender);
                $query->orWhere('Gender', 'Both');
            })->get()
        );
    }
}
