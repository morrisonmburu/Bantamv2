<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_planner extends Model
{
    protected  $table = "leave_planners";
    protected  $primaryKey = "leave_planner_id";
    public $incrementing = true;
    public $timestamps = true;
}
