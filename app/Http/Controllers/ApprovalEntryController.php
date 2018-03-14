<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\Employee;
use App\Http\Resources\ApprovalEntryCollection;
use App\Http\Resources\ApprovalEntryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\VarDumper\Dumper\esc;

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

    public function status(Request $request, ApprovalEntry $entry)
    {
        if($entry->Approver_ID != Auth::user()->Employee_Record->No){
            abort(401);
        }

        $validatedData = $request->validate([
            'status' => "required|in:Rejected|Approved"
        ]);

        $entry->status = $validatedData['status'];
        $entry->save();
    }

    public function employee_approvals(Request $request){
        $status = $request->query('status');

        $approvals = null;

        if($status){
            $approvals = ApprovalEntry::where("Status", $status)
                ->where("Approver_ID", Auth::user()->Employee_Record->No )->paginate();
        }
        else{
            $approvals = Auth::user()->Employee_Record->approvals()->paginate();
        }

        if($request->is('api*')){
            return new ApprovalEntryCollection($approvals);
        }
    }
}
