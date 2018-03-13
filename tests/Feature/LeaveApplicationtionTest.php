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
        $application->Status = "Open";
        $application->Application_Code = $code;
        $application->Leave_Code = $leave_type->Code;
        $application->Days_Applied = 5;
        $application->Start_Date = '2018-03-09';
        $application->End_Date = '2018-03-09';
        $application->Return_Date = '2018-03-09';
        $application->Application_Date = '2018-03-09';
        $application->save();

        $this->assertEquals(EmployeeLeaveApplication::where('Application_Code', $code)->get()->count(), 1);
        $no_of_approvers = 5;
        $entries = ApprovalEntry::where('Document_No', $code)->get();

        $this->assertEquals($no_of_approvers, $entries->count());
    }
}
