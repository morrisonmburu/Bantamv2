<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use OwenIt\Auditing\Contracts\Auditable;

class ApprovalEntry extends Model implements Auditable
{
    use NavDateTimeFormatter, \OwenIt\Auditing\Auditable;

    protected $fillable = [];
    protected $table = "approval_entries";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    protected $dates = [
        'Date_Time_Sent_for_Approval',
        'Last_Date_Time_Modified',
        'Web_Sync_TimeStamp',
        'Nav_Sync_TimeStamp',
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
        $this->setNavTime($value, "Web_Sync_TimeStamp");
    }

    public function setNavSyncTimeStampAttribute($value){
        $this->setNavTime($value, "Nav_Sync_TimeStamp");
    }

    public function setDateTimeSentForApprovalAttribute($value){
        $this->setNavTime($value, "Date_Time_Sent_for_Approval");
    }
    public function setLastDateTimeModifiedAttribute($value){
        $this->setNavTime($value, "Last_Date_Time_Modified");
    }
}
