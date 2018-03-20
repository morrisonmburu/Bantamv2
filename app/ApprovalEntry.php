<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class ApprovalEntry extends Model
{
    protected $guarded = [];
    protected $table = "approval_entries";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    protected $dates = [
        'Date_Time_Sent_for_Approval',
        'Web_Sync_TimeStamp',
    ];
    public static function boot()
    {
        parent::boot();
        static::updated(function (ApprovalEntry $entry){
            Event::fire('approval_entry.updated', $entry);
        });
    }

    public function employee(){
        return $this->belongsTo(Employee::class, "Sender_ID", "No");
    }

    public function approver(){
        return $this->belongsTo(Employee::class, "Approver_ID", "No");
    }

    public function leave_application(){
        return $this->belongsTo(EmployeeLeaveApplication::class, "Document_No", "Application_Code");
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
