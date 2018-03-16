<?php

namespace App\Http\Resources;

use App\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeApproverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arr =  parent::toArray($request);
        $arr['Approver_Details'] = new EmployeeResource($this->resource->approver);
        return $arr;
    }
}
