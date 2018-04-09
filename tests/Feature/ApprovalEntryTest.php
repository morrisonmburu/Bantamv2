<?php

namespace Tests\Feature;

use App\ApprovalEntry;
use App\Employee;
use App\EmployeeApprover;
use App\EmployeeLeaveApplication;
use App\LeaveType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApprovalEntryTest extends TestCase
{
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

    public function testFirstEntryOpen(){
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

        $entry = ApprovalEntry::where('Document_No', $code)->first();
        $this->assertEquals('Open', $entry->Status, "The status of the first ApprovalEntry of a new EmployeeLeaveApplication should be 'Open'");
    }

    public function testNextEntryOpen(){
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
        $application->save();

        $firstEntry = ApprovalEntry::where('Document_No', $code)->orderBy('Sequence_No', 'ASC')->first();
        $this->assertEquals('Open', $firstEntry->Status, "The status of the first ApprovalEntry of a new EmployeeLeaveApplication should be 'Open'");

        $secondEntry = ApprovalEntry::where('Document_No', $code)->where('Sequence_No', '>', $firstEntry->Sequence_No)
            ->orderBy('Sequence_No', 'ASC')->first();

        $this->assertEquals('Created', $secondEntry->Status, "The Status of an Approval Entry whose precursor's Status is 'Open' or 'Created' should be 'Created'");
        $firstEntry->Status = "Approved";

        $firstEntry->save();
        $secondEntry = $secondEntry->fresh();

        $this->assertEquals('Open', $secondEntry->Status, "The Status of an Approval Entry whose precursor's Status has been changed to 'Approved' should be 'Open'");

        $entries = ApprovalEntry::where('Document_No', $code)->where('Sequence_No', '>', $secondEntry->Sequence_No)
            ->orderBy('Sequence_No', 'ASC')->get();

        foreach ($entries as $entry){
            $this->assertEquals('Created', $entry->Status, "The Status of subsecuent Approval Entry after the second should still be 'Created'");

        }
    }
}
