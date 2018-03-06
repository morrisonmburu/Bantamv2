<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_leave_allocation extends Model
{
    protected $guarded = [];
    protected $table = "employee_leave_allocations";
    protected $primaryKey = "Entry_no";
    public $incrementing = true;
    public $timestamps = true;
}
