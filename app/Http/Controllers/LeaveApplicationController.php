<?php

namespace App\Http\Controllers;

use App\ApprovalEntry;
use App\Http\Resources\ChangelogResource;
use App\Notifications\employeeCanceledLeave;
use App\Notifications\LeaveApprovalRequestSent;
use App\Notifications\ApproverCanceledLeave;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    use Filterable;
    use CalculateDates;
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
        $this->authorize('create', EmployeeLeaveApplication::class);
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

        $manager = new NavSyncManager();
        $result = $manager->calculateLeaveDates(
            $validatedData->leave_code,
            Auth::user()->Employee_Record->No,
            Auth::user()->Employee_Record->_x003C_Base_Calendar_cODE_x003E_,
            $validatedData->start_date,
            $validatedData->end_date
        );

        if($result->lDays < 1){
            abort(400, "Cannot have 0 number of leave days");
        }

        $this->checkDatesOverlap($validatedData->start_date, $validatedData->end_date);
        $data = [
            "Employee_No" => Auth::user()->Employee_Record->No,
            "Leave_Code" => $validatedData->leave_code,
            "Start_Date" => $validatedData->start_date,
            "Days_Applied" => $validatedData->no_of_days,
            "Status" => "Review",
            "End_Date" => $validatedData->end_date,
            "Return_Date" => $validatedData->return_date,
            "Comments" => array_key_exists('comment', get_object_vars($validatedData))? $validatedData->comment : null,
            "Application_Date" => Carbon::now(),
            "Application_Code" => uniqid(),
            "Web_Sync" => true
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
        $application =EmployeeLeaveApplication::where(['Application_Code'=>$appCode])->first();
        $this->authorize('update',$application);

        if($request->user()->id = $application->employee->user->id){
            $application->Status="Canceled";
        }
        else if($application->employee->employee_approvers->contains($request->user()->Employee_Record)){
            $validatedData = $request->validate([
                'Approved_Start_Date' => 'required|date',
                'Approved_End_Date' => 'required|date',
            ]);
            $application->fill($validatedData);
            $application->Approval_Date = Carbon::now()->format('Y-m-d');
        }
        $application->Web_Sync = 0;
        $application->save();

        if ($request->is('api*')) {
            return  new LeaveApplicationResource($application);
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
        $leave_application->Web_Sync = true;
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
            return new EmployeeLeaveApplicationCollection(
                $this->filter($request, EmployeeLeaveApplication::class, $employee->Employee_leave_applications())
                ->orderBy('created_at', 'DESC')->paginate());
        }
    }

    public function requests(Request $request){
        $requests = Emp;

        if ($request->is('api*')) {
            return new EmployeeLeaveApplicationCollection($requests);
        }
    }

    public function leave_applications(Request $request){
        $applications = $this->filter($request->all(), EmployeeLeaveApplication::class)
            ->where("Employee_No", Auth::user()->Employee_Record->No )->paginate();
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

        return json_encode((array)$this->calculateEmployeeLeaveDates($validatedData));

    }

    public function disabled_days(Request $request){
        $all_dates = [];
        $start_end_dates =  $request->user()->Employee_Record->Employee_leave_applications()
            ->where('Status', '!=' , 'Canceled')
            ->select('start_date', 'end_date')->get();

        foreach ($start_end_dates as $start_end_date){
            $dates = $this->generateDateRange(Carbon::createFromFormat('Y-m-d', $start_end_date['start_date']),
                Carbon::createFromFormat('Y-m-d', $start_end_date['end_date']));
            $all_dates = array_merge ( $all_dates, $dates );
        }

        return json_encode($all_dates);
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    public function changelog(EmployeeLeaveApplication $leave_application, Request $request){
        return ChangelogResource::collection($leave_application->audits()->paginate());
    }
}
