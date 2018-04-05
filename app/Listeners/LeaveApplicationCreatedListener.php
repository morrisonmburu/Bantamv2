<?php

namespace App\Listeners;

use App\ApprovalEntry;
use App\EmployeeApprover;
use App\EmployeeLeaveApplication;
use App\Notifications\LeaveApprovalRequestSent;
use App\Notifications\NotifyApprover;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Jobs\SendLeaveApplicationToNav;
use App\Jobs\SendApprovalEntriesToNav;

class LeaveApplicationCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmployeeLeaveApplication $application)
    {
        if(!($application->Status == "Review" && $application->Web_Sync && !$application->Web_Sync_TimeStamp))
            return;
        $i = 1;
        $approvers = $application->employee->approvers()->orderBy('Approval_Level', 'ASC')->get();
        foreach ($approvers as $approver) {
            $approvalEntry = new ApprovalEntry();
            $approvalEntryData = [
                "Table_ID" => uniqid(),
                "Document_No" => $application->Application_Code,
                "Document_Type" => "Leave",
                "Sequence_No" => $approver->Approval_Level,
                "Status" => $i != 1 ? "Created" : "Open",
                "Approval_Details" => $approver->NamesApprvr,
                "Sender_ID" => $application->Employee_No,
                "Approver_ID" => $approver->Approver,
                "Document_Owner" => $application->Employee_No,
                "Date_Time_Sent_for_Approval" => Carbon::now()
            ];
            $approvalEntry->fill($approvalEntryData);
            $approvalEntry->save();
            SendApprovalEntriesToNav::dispatch($approvalEntry);
            if ($i == 1) {
                Notification::send($approver->approver->user, new NotifyApprover($approver->approver->user,
                    $approvalEntry));
                $application->save();
            }
            $i++;

        }
        Notification::send($application->employee->user,
            new LeaveApprovalRequestSent($application->employee->user, $application));
        SendLeaveApplicationToNav::dispatch($application);

    }
}
