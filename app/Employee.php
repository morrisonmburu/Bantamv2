<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table="employees";
    public $incrementing =true;
    protected $primaryKey="employee_id";
    public $timestamps = true;

    // Employee leave allocations
    public function Employee_leave_allocations(){
        return $this->hasMany("App\Employee_leave_allocation","employee_no","employee_id")
            ->orderByDesc("Leave_Period");
    }
    // Employee leave applications
    public function Employee_leave_applications(){
        return $this->hasMany("App\Employee_leave_applications","employee_no","employee_id")
            ->orderByDesc("Leave_Period");
    }

    //Get employee approval request
    public function Approval_Request(){
        return $this->hasMany("App\Approval_entry","user_id","id")
            ->join("employee_approvers","employee_approvers.id","=","approval_entries.Approver_id")
            ->join("approval_templates","approval_templates.id","=","approval_entries.Approval_template");
    }
}
