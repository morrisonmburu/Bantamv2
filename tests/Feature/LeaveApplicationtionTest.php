<?php

namespace Tests\Feature;

use App\ApprovalEntry;
use App\Employee;
use App\EmployeeApprover;
use App\EmployeeLeaveApplication;
use App\LeaveType;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveApplicationtionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected function setUp()
    {
        parent::setUp();
        factory(Employee::class, 20)->create();
        factory(LeaveType::class, 1)->create();

        $employee = Employee::all()->first();
        $employees = Employee::all();

        for($i = 1; $i < 6; $i++){
            $approver = new EmployeeApprover();
            $approver->Employee = $employee->No;
            $approver->Approver = $employees[$i]->No;
            $approver->NamesApprvr = $employees[$i]->First_Name;
            $approver->Comments = "Hello";
            $approver->Approval_Level = $i;
            $approver->save();
        }


    }

    public function testEntriesCreated(){
        $employee = Employee::all()->first();
        $leave_type = LeaveType::all()->first();

        $code = "LV0000";
        $application = new EmployeeLeaveApplication();
        $application->Leave_Period = "YR2018";
        $application->Employee_No = $employee->No;
        $application->Status = "Review";
        $application->Application_Code = $code;
        $application->Leave_Code = $leave_type->Code;
        $application->Days_Applied = 5;
        $application->Start_Date = '2018-03-09';
        $application->End_Date = '2018-03-09';
        $application->Return_Date = '2018-03-09';
        $application->Application_Date = '2018-03-09';
        $application->save();

        $this->assertEquals(EmployeeLeaveApplication::where('Application_Code', $code)->get()->count(), 1);
        $no_of_approvers = $employee->approvers()->count();
        $entries = ApprovalEntry::where('Document_No', $code)->get();

        $this->assertEquals($no_of_approvers, $entries->count(), 'ApprovalEntries should be created when a new EmployeeLeaveAppliciation is created');
    }

    public function testEntriesNotCreated(){
        $employee = Employee::all()->first();
        $leave_type = LeaveType::all()->first();

        $code = uniqid();
        $application = new EmployeeLeaveApplication();
        $application->Leave_Period = "YR2018";
        $application->Employee_No = $employee->No;
        $application->Status = "Review";
        $application->Application_Code = $code;
        $application->Leave_Code = $leave_type->Code;
        $application->Days_Applied = 5;
        $application->Start_Date = '2018-03-09';
        $application->End_Date = '2018-03-09';
        $application->Return_Date = '2018-03-09';
        $application->Application_Date = '2018-03-09';
        $application->Web_Sync = false;
        $application->save();
        $entries = ApprovalEntry::where('Document_No', $code)->get();
        $this->assertEquals(0, $entries->count(), 'No ApprovalEntries should be created when Web_Sync is false');

        $code = uniqid();
        $application = new EmployeeLeaveApplication();
        $application->Leave_Period = "YR2018";
        $application->Employee_No = $employee->No;
        $application->Status = "Review";
        $application->Application_Code = $code;
        $application->Leave_Code = $leave_type->Code;
        $application->Days_Applied = 5;
        $application->Start_Date = '2018-03-09';
        $application->End_Date = '2018-03-09';
        $application->Return_Date = '2018-03-09';
        $application->Application_Date = '2018-03-09';
        $application->Web_Sync = true;
        $application->Web_Sync_TimeStamp = Carbon::now();
        $application->save();
        $entries = ApprovalEntry::where('Document_No', $code)->get();
        $this->assertEquals(0, $entries->count(), 'No ApprovalEntries should be created when Web_Sync_TimeStamp is present');
    }

    public  function testCancelledApplication(){
        $employee = Employee::all()->first();
        $leave_type = LeaveType::all()->first();
        $code = "LV0000";
        $application = new EmployeeLeaveApplication();
        $application->Leave_Period = "YR2018";
        $application->Employee_No = $employee->No;
        $application->Status = "Review";
        $application->Application_Code = $code;
        $application->Leave_Code = $leave_type->Code;
        $application->Days_Applied = 5;
        $application->Start_Date = '2018-03-09';
        $application->End_Date = '2018-03-09';
        $application->Return_Date = '2018-03-09';
        $application->Application_Date = '2018-03-09';
        $application->save();

        $application->Status = "Canceled";
        $application->save();

        $entries = ApprovalEntry::where('Document_No', $code)->get();

        foreach ($entries as $entry){
            $this->assertEquals("Canceled", $entry->Status, "ApprovalEntry's status should be 'Canceled'");
        }
    }

    public function testRejectedApplication(){
        $employee = Employee::all()->first();
        $leave_type = LeaveType::all()->first();

        $approvers = $employee->approvers->sortBy('Approval_Level');

        $code = "LV0000";
        $application = new EmployeeLeaveApplication();
        $application->Leave_Period = "YR2018";
        $application->Employee_No = $employee->No;
        $application->Status = "Review";
        $application->Next_Approver = $approvers->first()->approver->No;
        $application->Application_Code = $code;
        $application->Leave_Code = $leave_type->Code;
        $application->Days_Applied = 5;
        $application->Start_Date = '2018-03-09';
        $application->End_Date = '2018-03-09';
        $application->Return_Date = '2018-03-09';
        $application->Application_Date = '2018-03-09';
        $application->Web_Sync = true;
        $application->save();

        $firstEntry = ApprovalEntry::where('Document_No', $code)
            ->where('Sender_ID', $employee->No)->first();

        $firstEntry->Status = "Rejected";
        $firstEntry->save();

        $entries = ApprovalEntry::where('Document_No', $code)->where('Sequence_No', '>', $firstEntry->Sequence_No)->get();

        foreach ($entries as $entry){
            $this->assertEquals('Rejected', $entry->Status);
        }
        $application = EmployeeLeaveApplication::find($application->id);
        $this->assertEquals('Rejected', $application->Status, "EmployeeLeaveApplication's status should be 'Rejected'");
    }


//    public function testApprovedApplication(){
//        $employee = Employee::all()->first();
//        $leave_type = LeaveType::all()->first();
//
//        $approvers = $employee->approvers->sortBy('Approval_Level');
//
//        $code = "LV0000";
//        $application = new EmployeeLeaveApplication();
//        $application->Leave_Period = "YR2018";
//        $application->Employee_No = $employee->No;
//        $application->Status = "Review";
//        $application->Next_Approver = $approvers->first()->approver->No;
//        $application->Application_Code = $code;
//        $application->Leave_Code = $leave_type->Code;
//        $application->Days_Applied = 5;
//        $application->Start_Date = '2018-03-09';
//        $application->End_Date = '2018-03-09';
//        $application->Return_Date = '2018-03-09';
//        $application->Application_Date = '2018-03-09';
//        $application->save();
//
//        $entries = ApprovalEntry::where('Document_No', $code)
//            ->where('Sender_ID', $employee->No)
//            ->orderBy('Sequence_No')
//            ->get();
//
//        foreach ($entries as $entry){
//            $entry->Status = "Approved";
//            $entry->save();
//        }
//
//        foreach ($entries as $entry){
//            $this->assertEquals('Approved', $entry->Status);
//        }
//        $application = EmployeeLeaveApplication::find($application->id);
//        $this->assertEquals('Approved', $application->Status);
//    }

}
