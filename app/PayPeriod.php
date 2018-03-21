<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PayPeriod extends Model
{
    protected $fillable = ["Starting_Date"];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
