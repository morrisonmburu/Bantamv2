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

    public function status(  $id, Request $request)
    {
        $entry = ApprovalEntry::find($id);

        if($entry->Approver_ID != Auth::user()->Employee_Record->No){
            abort(401);
        }

        $validatedData = $request->validate([
            'status' => "required|in:Rejected,Approved"
        ]);

        $entry->Status = $validatedData['status'];
        $entry->Nav_Sync = 0;
        $entry->save();
        return new ApprovalEntryResource($entry);
    }

    public function employee_approvals(Request $request, Employee $employee){
        return $this->getEmployeeApprovalEntries($request, $employee);
    }

    public function current_employee_approvals(Request $request){
        return $this->getEmployeeApprovalEntries($request,  Auth::user()->Employee_Record);
    }

    private function getEmployeeApprovalEntries(Request $request, Employee $employee){
        $status = $request->query('status');
        $approvals = null;
        if($status){
            $approvals = ApprovalEntry::where("Approver_ID", $employee->No );
            if(is_array($status)){
                $count = 0;

                foreach ($status as $s){
                    if($count == 0){
                        $approvals = $approvals->where("Status", $s);
                    }
                    else{
                        $approvals->orWhere("Status", $s);
                    }
                    $count++;
                }
            }
            else{
                $approvals = $approvals->where("Status", $status);
            }
        }
        else{
            $approvals = $employee->approvals();
        }

        if($request->is('api*')){
            return new ApprovalEntryCollection($approvals->paginate());
        }
    }
}
