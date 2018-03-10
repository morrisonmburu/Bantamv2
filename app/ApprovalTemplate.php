<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalTemplate extends Model
{
    protected $guarded = [];
    protected $table = "approval_templates";
    protected $primaryKey = "id";
    public $inrementing = true;
    public $timestamps = true;

    //Approval entries per template type
    public function Approval_entries(){
        return $this->hasMany(ApprovalEntry::class,"Approval_template",'id');
    }
}
