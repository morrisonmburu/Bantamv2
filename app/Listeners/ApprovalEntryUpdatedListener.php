<?php

namespace App\Listeners;

use App\ApprovalEntry;
use App\Jobs\SendApprovalEntriesToNav;
use App\Notifications\LeaveApplicationRejected;
use \Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovalEntryUpdatedListener
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
    public function handle(ApprovalEntry $entry)
    {

        if($entry->getOriginal()["Status"] == $entry->Status) return;
        switch ($entry->Status){
            case "Approved":
                $nextEntry = ApprovalEntry::where('Document_No', $entry->Document_No)
                    ->where('Sequence_No', '>', $entry->Sequence_No)
                    ->orderBy('Sequence_No')->first();
                $leave_application = $entry->leave_application;
                if($nextEntry){
                    $nextEntry->Status = "Open";
                    $nextEntry->Nav_Sync = 0;
                    $nextEntry->save();
                    Notification::send($nextEntry->approver->user, new \App\Notifications\NotifyApprover($nextEntry->approver->user,
                        $nextEntry));
                    $leave_application = $entry->leave_application;
                    $leave_application->Next_Approver = $nextEntry->Approver_ID;
                    $leave_application->Web_Sync = 0;
                    $leave_application->save();
                }
                else{
//                    $leave_application->Status = "Approved";
//                    $leave_application->Next_Approver = null;
//                    $leave_application->Nav_Sync = 0;
//                    $leave_application->save();
//                    Notification::send($leave_application->employee->user, new \App\Notifications\LeaveApprovalSuccess());
                }
                break;
            case "Rejected":
                $nextEntry = ApprovalEntry::where('Document_No', $entry->Document_No)
                    ->where('Sequence_No', '>', $entry->Sequence_No)
                    ->orderBy('Sequence_No')->first();

                if($nextEntry){
                    $nextEntry->Status = "Rejected";
                    $nextEntry->Web_Sync = 0;
                    $nextEntry->save();
                }
                else{
                    $leave_application = $entry->leave_application;
                    $leave_application->Status = "Rejected";
                    $leave_application->Next_Approver = null;
                    $leave_application->Web_Sync = 0;
                    $leave_application->save();

                    Notification::send($leave_application->employee->user,
                        new LeaveApplicationRejected($leave_application->employee->user, $leave_application));
                }
                break;
            case "Canceled":
                break;
            default:
                break;
        }
        SendApprovalEntriesToNav::dispatch($entry);
    }
}
