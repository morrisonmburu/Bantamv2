<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveApplication extends Model
{
    protected $guarded = [];
    protected $table = "employee_leave_applications";
    protected $primaryKey = "Application_Code";
    public $incrementing = true;
    public $timestamps = true;

    // Approval Entries

    public function Approval_Entry(){
        return $this->hasOne(ApprovalEntry::class,"Document_no","Application_Code");
    }
}
