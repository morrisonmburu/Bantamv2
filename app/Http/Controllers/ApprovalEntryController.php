<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\Employee;
use App\Http\Resources\ApprovalEntryCollection;
use App\Http\Resources\ApprovalEntryResource;
use Illuminate\Http\Request;

class ApprovalEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    public function show(Request $request, ApprovalEntry $entry)
    {
        if($request->is('api*')){
            return new ApprovalEntryResource($entry);
        }
    }

    public function employee_approvals(Request $request, Employee $employee){
        if($request->is('api*')){
            return new ApprovalEntryCollection($employee->approvals);
        }
    }
}
