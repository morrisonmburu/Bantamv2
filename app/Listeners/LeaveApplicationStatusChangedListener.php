<?php

namespace App\Listeners;

use App\EmployeeLeaveApplication;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use App\Notifications\canceledLeave;
use App\Notifications\LeaveApprovalRequestSent;
use App\Notifications\LeaveApprovalSuccess;
use App\Notifications\LeaveCanceled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LeaveApplicationStatusChangedListener
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
        if($application->getOriginal()["Status"] == $application->Status) return;
        switch ($application->Status){
            case "Canceled":
                Notification::send($application->employee->user,new canceledLeave($application->employee->user,$application));
                $entries = $application->approval_entries;
                foreach ($entries as $entry){
                    $entry->Status="Canceled";
                    $entry->Nav_Sync = 0;
                    $entry->save();
                    Notification::send($entry->employee->user,new LeaveCanceled($entry->employee->user,$application));
//                        SendApprovalEntriesToNav::dispatch($entry);
                }
                break;
            case "Review":
                Notification::send($application->employee->user, new LeaveApprovalRequestSent());
                Event::fire('employee_leave_application.created', $application);
                break;
            case "Approved":
                Notification::send($application->employee->user, new LeaveApprovalSuccess());
                break;
            default:
                break;
        }
    }
}
