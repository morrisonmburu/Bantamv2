<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_approval_process extends Model
{
    protected $table = "leave_approval_processes";
    protected $primaryKey = "approval_process_id";
    public $incrementing = true;
    public $timestamps = true;
}
