<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table="employees";
    public $incrementing =true;
    protected $primaryKey="employee_id";
    public $timestamps = true;
}
