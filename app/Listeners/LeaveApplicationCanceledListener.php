<?php

namespace App\Listeners;

use App\EmployeeLeaveApplication;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveApplicationCanceledListener
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
        $entries = $application->approval_entries;
        foreach ($entries as $entry){
            $entry->Status = "canceled";
            $entry->Nav_Sync = 0;
            $entry->save();
        }
    }
}
