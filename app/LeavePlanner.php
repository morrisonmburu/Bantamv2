<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeavePlanner extends Model
{
    protected $guarded = [];
    protected  $table = "leave_planners";
    protected  $primaryKey = "leave_planner_id";
    public $incrementing = true;
    public $timestamps = true;
}
