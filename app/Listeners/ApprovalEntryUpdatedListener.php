<?php

namespace App\Listeners;

use App\ApprovalEntry;
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
        if($entry->getOriginal()->Status == $entry->Status) return;

        switch ($entry->Status){
            case "Approved":
                $nextEntry = ApprovalEntry::where('Document_No', $entry->Document_No)
                    ->where('Sequence_No', '>', $entry->Sequence_No)
                    ->orderBy('Sequence_No')->first();
                $leave_application = $entry->leave_application;
                if($nextEntry){
                    $nextEntry->Status = "Open";
                    $nextEntry->save();
                    Notification::send($nextEntry->approver->user, new \App\Notifications\NotifyApprover());
                    $leave_application = $entry->leave_application;
                    $leave_application->Next_Approver = $nextEntry->Approver_ID;
                    $leave_application->save();
                }
                else{
                    $leave_application->Status = "Approved";
                    $leave_application->Next_Approver = null;
                    $leave_application->save();
                    Notification::send($nextEntry->approver->user, new \App\Notifications\LeaveApprovalSuccess());
                }
            case "Rejected":
                $nextEntry = ApprovalEntry::where('Document_No', $entry->Document_No)
                    ->where('Sequence_No', '>', $entry->Sequence_No)
                    ->orderBy('Sequence_No')->first();

                if($nextEntry){
                    $nextEntry->Status = "Rejected";
                    $nextEntry->save();
                }
                else{
                    $leave_application = $entry->leave_application;
                    $leave_application->Status = "Rejected";
                    Notification::send($nextEntry->approver->user, new \App\Notifications\LeaveApprovalFail());
                }
                break;
            case "Canceled":
                break;
            default:
                break;
        }
    }
}
