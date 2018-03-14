<?php

namespace App\Jobs;

use App\EmployeeLeaveApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\NavSoap\NavSyncManager;

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
        if ($this->attempts() > 2) {
            return;
        }
        $NavSyncManager = new NavSyncManager();
        $NavSyncManager->sendLeaveApplication($this->leaveApplication);
    }
}
