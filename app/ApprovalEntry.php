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
}
