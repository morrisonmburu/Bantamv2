<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Event;

class EmployeeLeaveApplication extends Model
{
    protected $guarded = [];
    protected $table = "employee_leave_applications";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    public  static function boot()
    {
        parent::boot();
        static::created(function ($employee_leave_application){
            Event::fire('employee_leave_application.created', $employee_leave_application);
        });

        static::updated(function ($employee_leave_application){
            if($employee_leave_application->getOriginal()["Status"] != $employee_leave_application->Status &&
                $employee_leave_application->Status == "Canceled")
            Event::fire('employee_leave_application.canceled', $employee_leave_application);
        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    public function approval_entries(){
        return $this->hasMany(ApprovalEntry::class,"Document_no","Application_Code");
    }

    public function employee(){
        return $this->belongsTo(Employee::class, "Employee_No", "No");
    }
}
