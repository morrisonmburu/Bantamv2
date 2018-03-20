<?php

namespace App\Jobs;

use App\EmployeeLeaveApplication;
use App\Notifications\LeaveApplicationFailed;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\NavSoap\NavSyncManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendLeaveApplicationToNav implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leaveApplication;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EmployeeLeaveApplication $application)
    {
        $this->leaveApplication = $application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $NavSyncManager = new NavSyncManager();
        $NavSyncManager->sendLeaveApplication($this->leaveApplication);
    }

    public function failed(Exception $exception)
    {
//        Notification::send(Auth::user(), new LeaveApplicationFailed());
    }
}
