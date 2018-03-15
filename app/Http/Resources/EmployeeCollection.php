<?php

namespace App\Http\Resources;

use App\EmployeeApprover;
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
        $arrs = parent::toArray($request);
        $new_arrs = [];
        foreach($arrs as $arr){
            $arr["is_approver"] = EmployeeApprover::where('Approver', $arr['No'])->count() > 0;
            array_push($new_arrs, $arr);
        }

        return $new_arrs;
    }
}
