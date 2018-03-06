<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_leave_application extends Model
{
    protected $guarded = [];
    protected $table = "employee_leave_applications";
    protected $primaryKey = "Application_Code";
    public $incrementing = true;
    public $timestamps = true;

    // Approval Entries

    public function Approval_Entry(){
        return $this->hasOne("App\Approval_entry","Document_no","Application_Code");
    }
}
