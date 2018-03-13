<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\EmployeeApprover;
use App\EmployeeLeaveAllocation;
use App\Notifications\cancelledLeave;
use App\Notifications\LeaveCancelled;
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
use Mockery\Exception;

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
        $LeaveApplication->save();
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
    public function update(Request $request, EmployeeLeaveApplication $employeeLeaveApplication,$appCode)
    {
        try{
            $appRec=$employeeLeaveApplication::where(["Application_Code"=>$appCode])->first();
            if($employeeLeaveApplication->where(["Application_Code"=>$appCode])->update(["status"=>"Cancelled"])){
                Notification::send(Auth::User(),new cancelledLeave(Auth::user(),$appRec));
                $appEntry=ApprovalEntry::where(["Document_No"=>$appRec->Application_Code])->get();
                foreach ($appEntry as $entry){
                    ApprovalEntry::where(["Table_ID"=>$entry->Table_ID])->update(["Status"=>"Cancelled"]);
                    $approver = EmployeeApprover::where(["Approver"=>$entry->Approver_ID])->first();
                    Notification::send($approver->employee->user,new LeaveCancelled($approver->employee->user,$appRec));
                }
            }
            return  "Success";
        }catch(Exception $e){
            return $e->getMessage();
        }
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
