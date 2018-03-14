<?php

namespace App\Http\Resources;

use App\EmployeeApprover;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arr = parent::toArray($request);
        $arr["is_approver"] = EmployeeApprover::where('Approver', $arr['No'])->count() > 0;
        return $arr;
    }
}
