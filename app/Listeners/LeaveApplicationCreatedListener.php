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
        try {
            $approvers = EmployeeApprover::where(["Employee" => $application->Employee_No])->orderBy('Approval_Level')->get(); // Returns all approvers in the list

            if (count($approvers)>0){
                try{
                    $i=1;
                    foreach ($approvers as $approver) {
                        $approvalEntry = new ApprovalEntry();
                        $unqueid = uniqid();
                        print ($unqueid);
                        $approvalEntryData=[
                            "Table_ID"=> $unqueid,
                            "Document_No"=>$application->Application_Code,
                            "Document_Type"=>"Leave",
                            "Sequence_No"=>$approver->Approval_Level,
                            "Status" => $i!=1?"Created":"Open",
                            "Approval_Details" => $approver->NamesApprvr,
                            "Sender_ID" => $application->Employee_No,
                            "Approver_ID" => $approver->Approver,
                            "Document_Owner" => $application->Employee_No,
                            "Date_Time_Sent_for_Approval" =>DB::raw('CURRENT_TIMESTAMP')
                        ];
                        $approvalEntry->fill($approvalEntryData);
                        $approvalEntry->save();

                        if($i == 1) Notification::send($approver->employee->user, new NotifyApprover());
                        $i++;
                    }
                }catch(\Exception $e){
                    throw new \Exception('Error occurred while creating approval entry:' . $e->getMessage());
                }
            }else{
            }

        }catch(ModelNotFoundException $e){
            throw new \Exception('You don\'t have any approver:'.$e->getMessage() . $e->getMessage());
        }
    }
}
