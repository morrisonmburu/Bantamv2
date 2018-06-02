<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\LeaveType;
use OwenIt\Auditing\Contracts\Auditable;

class Employee extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table="employees";
    public $incrementing =true;
    protected $primaryKey="id";
    public $timestamps = true;

    public  static function boot()
    {
        parent::boot();

        static::created(function ($employee){
           Event::fire('employee.created', $employee);
        });
    }

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
        return $this->hasMany(ApprovalEntry::class,"Approver","No")->orderByDesc("updated_at");
    }

    //Gets Employee leave planners
    public function Employee_Leave_Planners(){
        return $this->hasMany(LeavePlanner::class,"Employee_No","No");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function approvals(){
        return $this->hasMany(ApprovalEntry::class, 'Approver_ID', 'No');
    }
    public function approvers(){
        return $this->hasMany(
            EmployeeApprover::class,
            'Employee',
            'No'
        );
    }

    public function approvees(){
        return $this->hasMany(
            EmployeeApprover::class,
            'Approver',
            'No'
        );
    }

    public function employee_approvers(){
        return $this->hasManyThrough(
            Employee::class,
            EmployeeApprover::class,
            'Employee',
            'No',
            'No',
            'Approver'

        );
    }

    public function employee_approvees(){
        return $this->hasManyThrough(
            Employee::class,
            EmployeeApprover::class,
            'Approver',
            'No',
            'No',
            'Employee'

        );
    }


    public function leave_types(){
        return $this->hasManyThrough(
            LeaveType::class,
            EmployeeLeaveAllocation::class,
            'Employee_No',
            'Code',
            'No',
            'Leave_Code'

        );
    }

    public function saveProfilePic($encodedImage){
        try{
            $decodedImage = base64_decode($encodedImage);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimetype = $finfo->buffer($decodedImage);
            $mime_arr = explode('/', $mimetype );
            $extension = end($mime_arr);
            switch ($extension){
                case 'x-ms-bmp':
                    $extension = "bmp";
                    break;
            }
            $filename = "image.$extension";
            $path = "employees/$this->No/profile_picture/$filename";

            if($extension != "x-empty"){
                Storage::disk('local')->put($path, $decodedImage);
                $this->Profile_Picture = $filename;
                $this->save();
            }
            else{
                $this->Profile_Picture = null;
                $this->save();
            }
            return true;
        }
        catch (\Exception $e){
            print($e);
            return false;
        }
    }
}
