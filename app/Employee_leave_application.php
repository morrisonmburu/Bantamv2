<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_leave_application extends Model
{
    protected $table = "employee_leave_applications";
    protected $primaryKey = "Application_Code";
    public $incrementing = true;
    public $timestamps = true;
}
