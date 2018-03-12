<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeApprover extends Model
{
    protected $guarded = [];
    protected $table = "employee_approvers";
    protected $primaryKey = "Approver_id";
    public $incrementing = true;
    public $timestamps = true;

    //approval entries per an approver
    public function Approval_entries(){
        return $this->hasMany(ApprovalEntry::class,"Approver_id",'id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, "Employee", "No");
    }

    public function approver(){
        return $this->belongsTo(Employee::class, "Approver", "No");
    }
}
