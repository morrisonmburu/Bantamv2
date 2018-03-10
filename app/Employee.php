<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Employee extends Model
{
    protected $table="employees";
    public $incrementing =true;
    protected $primaryKey="id";
    public $timestamps = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    // Employee leave allocations
    public function Employee_leave_allocations(){
        return $this->hasMany(EmployeeLeaveAllocation::class,"Employee_No","No")
            ->orderByDesc("Leave_Period");
    }

    // Employee leave applications
    public function Employee_leave_applications(){
        return $this->hasMany(EmployeeLeaveApplication::class,"Employee_No","No")
            ->orderByDesc("Leave_Period");
    }

    //Gets employee approval request
    public function Approval_Request(){
        return $this->hasMany(ApprovalEntry::class,"Employee_No","No")
            ->join("employee_approvers","employee_approvers.id","=","approval_entries.Approver_id")
            ->join("approval_templates","approval_templates.id","=","approval_entries.Approval_template");
    }

    //Gets Employee leave planners
    public function Employee_Leave_Planners(){
        return $this->hasMany(LeavePlanner::class,"Employee_No","No");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
