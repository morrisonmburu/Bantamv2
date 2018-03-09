<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalEntry extends Model
{
    protected $guarded = [];
    protected $table = "approval_entries";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

}
