<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeLeaveApplication extends Model
{
    protected $guarded = [];
    protected $table = "employee_leave_applications";
    protected $primaryKey = "Application_Code";
    public $incrementing = true;
    public $timestamps = true;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    public function Approval_Entry(){
        return $this->hasOne(ApprovalEntry::class,"Document_no","Application_Code");
    }
}
