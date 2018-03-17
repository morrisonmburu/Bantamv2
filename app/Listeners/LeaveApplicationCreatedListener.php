<?php

namespace App\Listeners;

use App\ApprovalEntry;
use App\EmployeeApprover;
use App\EmployeeLeaveApplication;
use App\Notifications\NotifyApprover;
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
        if($application->Status != "Review") return;
        try {
            if($application->Nav_Sync == 0) {
                $i = 1;
                $approvers = $application->employee->approvers;
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
                        "Date_Time_Sent_for_Approval" => DB::raw('CURRENT_TIMESTAMP')
                    ];
                    $approvalEntry->fill($approvalEntryData);
                    $approvalEntry->save();
//                    SendApprovalEntriesToNav::dispatch($approvalEntry);
                    if ($i == 1) {
                        Notification::send($approver->approver->user, new NotifyApprover());
                        $application->save();
                    }
                    $i++;

                }
                try {
                    SendLeaveApplicationToNav::dispatch($application);
                } catch (\Exception $e) {
                    throw new \Exception("Error sending application to Nav:" . $e->getMessage());
                }
            }

        }catch(\Exception $e){
            throw new \Exception('Error occurred while creating approval entry:' . $e->getMessage());
        }
    }
}
