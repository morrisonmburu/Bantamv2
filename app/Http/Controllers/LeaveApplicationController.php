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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveApplicationRequest as LeaveRequest;
use App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection(EmployeeLeaveApplication::all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


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
                if ($this->createApprovalEntry($data)){
                    Notification::send(Auth::user(),new LeaveApprovalRequestSent());
                    return response('Success', 200)->header('Content-Type', 'text/plain');
                }else{
                    return response("Failed! You don't have any approver",500)->header('Content-Type', 'text/plain');
                }
            }else{
                return response("Failed! Leave application not created.",500)->header('Content-Type', 'text/plain');
            }

        } catch (\Exception $e) {
            return response('Error occurred:' . $e->getMessage(), 500)->header('Content-Type', 'text/plain');
        }
    }

    public function createApprovalEntry($data){
        $approvalEntry = new ApprovalEntry();
        try {
            $approver = EmployeeApprover::where(["Employee" => Auth::user()->Employee_Record->No])->first(); // Returns first approver in the list
            if (count($approver)>0){
                try{
                    $approvalEntryData=[
                        "Table_ID"=>uniqid(),
                        "Document_No"=>$data["Application_Code"],
                        "Document_Type"=>"Leave",
                        "Sequence_No"=>$approver->Approval_Level,
                        "Status" => "Pending",
                        "Approval_Details" => $approver->NamesApprvr,
                        "Sender_ID" => $data["Employee_No"],
                        "Approver_ID" => $approver->Approver,
                        "Document_Owner" => $data["Employee_No"],
                        "Date_Time_Sent_for_Approval" =>DB::raw('CURRENT_TIMESTAMP')
                    ];
                    $approvalEntry->fill($approvalEntryData);
                    if ($approvalEntry->save()) {
                        Notification::send($approver->user, new NotifyApprover());
                        return true;
                    }else{
                        return false;
                    }
                }catch(\Exception $e){
//                    return 'Error occurred while creating approval entry:' . $e->getMessage();
                return false;
                }
            }else{
                return false;
            }

        }catch(ModelNotFoundException $e){
//            return 'Error!You don\'t have any approver';
            return false;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     */
    public function show(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        if ($request->is('api*')) {
            return new LeaveApplicationResource($employeeLeaveApplication);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeLeaveApplication $employeeLeaveApplication)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeLeaveApplication $employeeLeaveApplication
     * @return \Illuminate\Http\Response
     */
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
