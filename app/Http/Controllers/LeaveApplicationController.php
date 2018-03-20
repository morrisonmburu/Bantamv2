<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\Notifications\canceledLeave;
use App\Notifications\LeaveApprovalRequestSent;
use App\Notifications\LeaveCanceled;
use Carbon\Carbon;
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
use App\Jobs\SendApprovalEntriesToNav;

class LeaveApplicationController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', EmployeeLeaveApplication::class);
        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection(EmployeeLeaveApplication::paginate());
        }
    }

    public function create()
    {
        $this->authorize('create', EmployeeLeaveApplication::class);
    }

    public function store(LeaveRequest $request)
    {
        $validatedData = (object) $request->validate([
            'end_date' => 'required|date',
            'start_date' => 'required|date',
            'handOverTo' => 'required|exists:employees,No',
            'leave_code' => 'required|exists:leave_types,Code',
            'no_of_days' => 'required|numeric',
            'return_date' => 'required|date',
            'status' => 'required|in:Review,New',
            'comment' => 'sometimes',
        ]);
        $LeaveApplication = new EmployeeLeaveApplication();
        $this->authorize('create', EmployeeLeaveApplication::class);
        $this->checkDatesOverlap($validatedData->start_date, $validatedData->end_date);
        $data = [
            "Employee_No" => Auth::user()->Employee_Record->No,
            "Leave_Code" => $validatedData->leave_code,
            "Start_Date" => $validatedData->start_date,
            "Days_Applied" => $validatedData->no_of_days,
            "Status" => $validatedData->status,
            "End_Date" => $validatedData->end_date,
            "Return_Date" => $validatedData->return_date,
            "Comments" => $validatedData->comment,
            "Application_Date" => Carbon::now(),
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
    public function show(Request $request, EmployeeLeaveApplication $leave_application)
    {
        $this->authorize('view',$leave_application);
        if ($request->is('api*')) {
            return new LeaveApplicationResource($leave_application);
        }
    }
    public function edit(EmployeeLeaveApplication $leave_application)
    {
        $this->authorize('update',$leave_application);
    }
    public function update(Request $request,$appCode)
    {

        if ($request->is('api*')) {
            try{
                $employeeLeaveApplication =EmployeeLeaveApplication::where(['Application_Code'=>$appCode])->first();
                $this->authorize('update',$employeeLeaveApplication);
                $employeeLeaveApplication->Web_Sync = 0;
                $employeeLeaveApplication->status="Canceled";
                if($employeeLeaveApplication->save()){
                    Notification::send(Auth::User(),new canceledLeave(Auth::user(),$employeeLeaveApplication));
                    $appEntry=$employeeLeaveApplication->approval_entries;
                    foreach ($appEntry as $entry){
                        $entry->Status="Canceled";
                        $entry->Web_Sync = 0;
                        $entry->save();
                        Notification::send($entry->employee->user,new LeaveCanceled($entry->employee->user,$employeeLeaveApplication));
//                        SendApprovalEntriesToNav::dispatch($entry);
                    }
                }

                return  "Success";
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    }

    public function status(Request $request,  $leave_application)
    {
//        $this->authorize('update', $leave_application);
        $leave_application = EmployeeLeaveApplication::find($leave_application);
        $validatedData = (object)$request->validate([
           'Status' => 'in:Review,Canceled'
        ]);

        $leave_application->Web_Sync = 0;

        switch ($validatedData->Status){
            case 'Canceled':
                if ($leave_application->Status != "Review")
                    abort(400, "Cannot Cancel an application which is not in review");
                break;
            case 'Review':
                if($leave_application->Status != "New" /*|| !$leave_application->Status*/)
                    abort(400, "Cannot send application");
                break;
        }
        $leave_application->Status = $validatedData->Status;
        $leave_application->save();

        if ($request->is('api*')) {
            return new LeaveApplicationResource($leave_application);
        }
    }

    public function destroy(EmployeeLeaveApplication $employeeLeaveApplication)
    {
        $this->authorize('delete', $employeeLeaveApplication);

        if(!$employeeLeaveApplication != "New"){
            abort(400, "Cannot delete an application which is not new");
        }

        return $employeeLeaveApplication->delete();

    }

    public function EmployeeLeaveApplications(Employee $employee, Request $request)
    {

        $this->authorize('employee', [EmployeeLeaveApplication::class, $employee]);
        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection($employee->Employee_leave_applications()->orderBy('created_at', 'DESC')->paginate());
        }
    }

    public function requests(Request $request){
        $requests = Emp;

        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection($requests);
        }
    }

    public function leave_applications(Request $request){
        $status = $request->query('status');

        $applications = null;

        if($status){
            $applications = EmployeeLeaveApplication::where("Employee_No", Auth::user()->Employee_Record->No );
            if(is_array($status)){
                $count = 0;
                foreach ($status as $s){
                    if($count == 0){
                        $applications = $applications->where("Status", $s);
                    }
                    else{
                        $applications->orWhere("Status", $s);
                    }
                    $count++;
                }
            }
            else{
                $applications = $applications->where("Status", $status);
            }
            $applications = $applications->orderBy('created_at', 'DESC')->paginate();
        }
        else{
            $applications = Auth::user()->Employee_Record->Employee_leave_applications()->paginate();
        }
//        dd($applications);
        if($request->is('api*')){
            return new EmployeeLeaveApplicationCollection($applications);
        }
    }

    public function calculateLeaveDates(Request $request)
    {


        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'leave_code' => 'required'
        ]);

        $this->checkDatesOverlap($validatedData['start_date'], $validatedData['end_date']);
        $manager = new NavSyncManager();

        try {
            $result = $manager->calculateLeaveDates(
                $validatedData['leave_code'],
                Auth::user()->Employee_Record->No,
                Auth::user()->Employee_Record->_x003C_Base_Calendar_cODE_x003E_,
                $validatedData['start_date'],
                $validatedData['end_date']
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

    public function disabled_days(Request $request){
        return $request->user()->Employee_Record->Employee_leave_applications()
            ->select('start_date', 'end_date')->get();
    }

    private function checkDatesOverlap($start_date, $end_date ){
        if(EmployeeLeaveApplication::where(function ($q) use($start_date) {
            $q->where('Start_Date', '<=', $start_date);
            $q->where('End_Date', '>=', $start_date);
        })->orWhere(function ($q) use($end_date) {
            $q->where('Start_Date', '<=', $end_date);
            $q->where('End_Date', '>=', $end_date);
        })->count())
        {
            abort(400, "Leave application overlaps with another.");
        }
    }
}
