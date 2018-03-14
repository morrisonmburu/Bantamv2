<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
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
