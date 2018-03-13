<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\EmployeeApprover;
use App\EmployeeLeaveAllocation;
use App\Notifications\NotifyApprover;
use Illuminate\Support\Facades\Notification;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\Http\Resources\EmployeeLeaveApplicationCollection;
use App\Http\Resources\LeaveApplicationResource;
use App\Notifications\LeaveApprovalRequestSent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveApplicationRequest as LeaveRequest;
use App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeaveApplicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection(EmployeeLeaveApplication::all());
        }
    }

    public function create()
    {
        //
    }

    public function store(LeaveRequest $request,EmployeeLeaveApplication $LeaveApplication)
    {
        $data = [
            "Employee_No" => Auth::user()->Employee_Record->No,
            "Leave_Code" => $request->leave_code,
            "Start_Date" => $request->start_date,
            "Days_Applied" => $request->no_of_days,
            "Application_Code" => uniqid()
        ];
        $LeaveApplication->fill($data);
        try {
            if ($LeaveApplication->save()) {
                if ($this->createApprovalEntry($data) ){
                    Notification::send(Auth::user(),new LeaveApprovalRequestSent());
                    return response('Success', 200)->header('Content-Type', 'text/plain');
                }else{
                    return response('Error occurred creating leave approval request entry:',500)->header('Content-Type', 'text/plain');
                }
            }else{
                return response("Failed! Leave application not created.",500)->header('Content-Type', 'text/plain');
            }

        } catch (\Exception $e) {
            return response('Error occurred:' . $e->getMessage(), 500)->header('Content-Type', 'text/plain');
        }
    }

    public function createApprovalEntry($data){
        try {
            $approvers = EmployeeApprover::where(["Employee" => Auth::user()->Employee_Record->No])->get(); // Returns all approvers in the list
            if (count($approvers)>0){
                try{
                    $i=1;
                    foreach ($approvers as $approver) {
                        $approvalEntry = new ApprovalEntry();
                        $approvalEntryData=[
                            "Table_ID"=>uniqid(),
                            "Document_No"=>$data["Application_Code"],
                            "Document_Type"=>"Leave",
                            "Sequence_No"=>$approver->Approval_Level,
                            "Status" => $i!=1?"Pending":"Open",
                            "Approval_Details" => $approver->NamesApprvr,
                            "Sender_ID" => $data["Employee_No"],
                            "Approver_ID" => $approver->Approver,
                            "Document_Owner" => $data["Employee_No"],
                            "Date_Time_Sent_for_Approval" =>DB::raw('CURRENT_TIMESTAMP')
                        ];
                        $approvalEntry->fill($approvalEntryData);
                        $approvalEntry->save();
                        Notification::send($approver->employee->user, new NotifyApprover());
                        $i++;
                    }
                    return true;
                }catch(\Exception $e){
                    return 'Error occurred while creating approval entry:' . $e->getMessage();
                }
            }else{
                return false;
            }

        }catch(ModelNotFoundException $e){
            return 'You don\'t have any approver:'.$e->getMessage();
        }
    }
    public function checkIfNotExists($params){
        $approvalEntry = new ApprovalEntry();
        if (count($approvalEntry::where($params))>0){
            return false;
        }
        return true;
    }
    public function show(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        if ($request->is('api*')) {
            return new LeaveApplicationResource($employeeLeaveApplication);
        }
    }
    public function edit(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }
    public function update(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {

    }
    public function destroy(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    public function EmployeeLeaveApplications(Employee $employee, Request $request)
    {

        if ($request->is('api*')) {
            return new LeaveApplicationResource($employee->Employee_leave_applications);
        }
    }

    public function requests(Request $request){
        $requests = Emp;

        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection($requests);
        }
    }

    public function calculateLeaveDates(Request $request)
    {

        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'no_of_days' => 'required|numeric',
            'leave_code' => 'required'
        ]);

        $manager = new NavSyncManager();

        try {
            $result = $manager->calculateLeaveDates(
                $validatedData['leave_code'],
                Auth::user()->Employee_Record->No,
                Auth::user()->Employee_Record->_x003C_Base_Calendar_cODE_x003E_,
                $validatedData['start_date'],
                $validatedData['no_of_days']
            );
        } catch (\Exception $e) {
            if ($e->getCode() == NavSyncManager::$NAV_HTTP_ERROR_CODE)
                abort(400, $e->getMessage());
            else {
                throw $e;
            }
        }

        return json_encode((array)$result);

    }
}
