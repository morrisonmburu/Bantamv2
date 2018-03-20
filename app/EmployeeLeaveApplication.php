<?php

namespace App;

use Carbon\Carbon;
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

    protected $dates = [
        'Nav_Sync_TimeStamp',
        'Web_Sync_TimeStamp',
    ];

    public  static function boot()
    {
        parent::boot();
        static::created(function ($employee_leave_application){
            Event::fire('employee_leave_application.created', $employee_leave_application);
        });

        static::updated(function ($employee_leave_application){
            if(isset($employee_leave_application->getOriginal()["Status"])
                && $employee_leave_application->getOriginal()["Status"] != $employee_leave_application->Status)
                Event::fire('employee_leave_application.updated.status', $employee_leave_application);
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

    public function setNavSyncTimeStampAttribute($value){
        $name = "Nav_Sync_TimeStamp";
        try{
            $this->attributes[$name] =  Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d H:i:s');
        }
        catch (\Exception $e){
            $this->attributes[$name] =  Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $value)->format('Y-m-d H:i:s');
        }

    }

    public function setWebSyncTimeStampAttribute($value){
        $name = "Web_Sync_TimeStamp";
        try{
            $this->attributes[$name] =  Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d H:i:s');
        }
        catch (\Exception $e){
            $this->attributes[$name] =  Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $value)->format('Y-m-d H:i:s');
        }

    }

    public function toArray(){
        $arr =  parent::toArray();
        foreach ($arr as $key => $value){
            if ( isset($this->dates) && in_array( $key, $this->dates ) ) {
                try {
                    $arr[$key] = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$key])->format('Y-m-d\TH:i:s');
                }
                catch (\Exception $e){
                }
            }
        }
        return $arr;
    }
}
