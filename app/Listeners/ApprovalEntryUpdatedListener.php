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
        switch ($entry->Status){
            case "Approved":
                $approvers = $entry->employee->approvers->where('Approval_Level', '>', $entry->Sequence_No)
                    ->orderBy('Sequence_No');
                $nextApprover = $approvers->first();
                $nextEntry = new ApprovalEntry();
                $nextEntry->Table_ID = uniqid();
                $nextEntry->Document_Type = $entry->Document_Type;
                $nextEntry->Document_No = $entry->Document_No;
                $nextEntry->Status = "Open";
                $nextEntry->Sequence_No = $nextApprover->Approval_Level;
                $nextEntry->Sender_ID = $entry->Sender_ID;
                $nextEntry->Approver_ID = $nextApprover->approver->No;

                $nextEntry->save();

                $leave_application = $entry->leave_application;
                $leave_application->Next_Approver = $nextEntry->Approver_ID;
                $leave_application->save();

                Notification::send($nextApprover->approver->user, new \App\Notifications\NotifyApprover());



                break;
            default:
                break;
        }
    }
}
