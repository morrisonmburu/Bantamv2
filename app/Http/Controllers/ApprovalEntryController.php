<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\Employee;
use App\EmployeeLeaveApplication;
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
            'status' => "required|in:Rejected,Approved",
            'Approved_Start_Date' => 'sometimes|date',
            'Approved_End_Date' => 'sometimes|date',
        ]);

        $entry->Status = $validatedData['status'];
        $entry->Web_Sync = 1;
        $entry->save();

        $application = $entry->leave_application;
        $application->Approved_Start_Date =  isset($validatedData['Approved_Start_Date']) ?
            isset($validatedData['Approved_Start_Date']) : null;
        $application->Approved_End_Date = isset($validatedData['Approved_End_Date']) ?
            isset($validatedData['Approved_End_Date']) : null;

        $application->Approval_Date = Carbon::now()->format('Y-m-d');
        $application->Web_Sync = 1;
        $application->save();

        return new ApprovalEntryResource($entry);
    }

    public function employee_approvals(Request $request, Employee $employee){
        return $this->getEmployeeApprovalEntries($request, $employee);
    }

    public function current_employee_approvals(Request $request){
        return $this->getEmployeeApprovalEntries($request,  Auth::user()->Employee_Record);
    }

    public function application_approvals( EmployeeLeaveApplication $leave_application, Request $request ){
        return ApprovalEntryResource::collection($leave_application->approval_entries);
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
