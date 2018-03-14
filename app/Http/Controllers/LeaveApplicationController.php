<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\Notifications\canceledLeave;
use App\Notifications\LeaveApprovalRequestSent;
use App\Notifications\LeaveCanceled;
use Illuminate\Support\Facades\Notification;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\Http\Resources\EmployeeLeaveApplicationCollection;
use App\Http\Resources\LeaveApplicationResource;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveApplicationRequest as LeaveRequest;
use App\Employee;
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
//            "End_Date" => $request->end_date,
//            "Return_Date" => $request->return_date,
//            "Application_Date" => Carbon::now(),
            "Application_Code" => uniqid()
        ];
        $LeaveApplication->fill($data);
        $LeaveApplication->save();
        Notification::send(Auth::user(), new LeaveApprovalRequestSent());
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
    public function update(Request $request,$appCode)
    {
        if ($request->is('api*')) {
            try{
                $employeeLeaveApplication =EmployeeLeaveApplication::where(['Application_Code'=>$appCode])->first();
                $employeeLeaveApplication->Nav_Sync = 0;
                $employeeLeaveApplication->status="Canceled";
                if($employeeLeaveApplication->save()){
                    Notification::send(Auth::User(),new canceledLeave(Auth::user(),$employeeLeaveApplication));
                    $appEntry=$employeeLeaveApplication->approval_entries;
                    foreach ($appEntry as $entry){
                        $entry->Status="Canceled";
                        $entry->Nav_Sync = 0;
                        $entry->save();
                        Notification::send($entry->employee->user,new LeaveCanceled($entry->employee->user,$employeeLeaveApplication));
                    }
                }

                return  "Success";
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    }
    public function destroy(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    public function EmployeeLeaveApplications(Employee $employee, Request $request)
    {

        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection($employee->Employee_leave_applications);
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
