<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeLeaveAllocation extends Model
{
    protected $guarded = [];
    protected $table = "employee_leave_allocations";
    protected $primaryKey = "Entry_no";
    public $incrementing = true;
    public $timestamps = true;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }
}
