<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Employee extends Model
{
    protected $table="employees";
    public $incrementing =true;
    protected $primaryKey="employee_id";
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        static::created(function($employee){
            try{
//                $user = new User();
//                $user->password = Hash::make(uniqid());
//                $user->email = $employee->email;
//                $user->save();
//                $user->name = "";
            }
            catch (\Exception $e){
                dd($e->getMessage());
            }

        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }

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

    //Gets employee approval request
    public function Approval_Request(){
        return $this->hasMany("App\Approval_entry","user_id","id")
            ->join("employee_approvers","employee_approvers.id","=","approval_entries.Approver_id")
            ->join("approval_templates","approval_templates.id","=","approval_entries.Approval_template");
    }

    //Gets Employee leave planners
    public function Employee_Leave_Planners(){
        return $this->hasMany("App\Leave_planner","Employee_No","Employee_id");
    }

    public function user(){
        return $this->belongsTo("App\User");
    }
}
