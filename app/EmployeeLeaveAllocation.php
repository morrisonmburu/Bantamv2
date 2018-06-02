<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class EmployeeLeaveAllocation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    protected $table = "employee_leave_allocations";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'Employee_No', 'No');
    }
}
