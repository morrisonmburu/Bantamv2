<?php

namespace App\Listeners;

use App\EmployeeLeaveApplication;
use App\Jobs\SendApprovalEntriesToNav;
use App\Jobs\SendLeaveApplicationToNav;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use App\Notifications\employeeCanceledLeave;
use App\Notifications\LeaveApprovalRequestSent;
use App\Notifications\LeaveApplicationApproved;
use App\Notifications\ApproverCanceledLeave;
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
//        SendLeaveApplicationToNav::dispatch($application);
        switch ($application->Status){
            case "Canceled":
                Notification::send($application->employee->user,new EmployeeCanceledLeave($application->employee->user,$application));
                $entries = $application->approval_entries;
                foreach ($entries as $entry){
                    $status = $entry->Status;
                    $entry->Status="Canceled";
                    $entry->Web_Sync = 1;
                    $entry->save();
                    if($status == "Open")
                        Notification::send($entry->approver->user,new ApproverCanceledLeave($entry->approver->user, $entry));
                    SendApprovalEntriesToNav::dispatch($entry);
                }
                break;
            case "Review":
                Notification::send($application->employee->user, new LeaveApprovalRequestSent(
                    $application->employee->user, $application
                ));
                Event::fire('employee_leave_application.created', $application);
                break;
            case "Approved":
                Notification::send($application->employee->user, new LeaveApplicationApproved($application->employee->user, $application));
                break;
            default:
                break;
        }
    }
}
