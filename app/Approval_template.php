<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval_template extends Model
{
    protected $table = "approval_templates";
    protected $primaryKey = "id";
    public $inrementing = true;
    public $timestamps = true;

    //Approval entries per template type
    public function Approval_entries(){
        return $this->hasMany("App\Approval_entry","Approval_template",'id');
    }
}
