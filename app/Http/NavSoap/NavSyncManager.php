<?php
namespace App\Http\NavSoap;
use App\ApprovalEntry;
use App\Employee;
use App\EmployeeApprover;
use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NTLMStream;
use App\LeaveType;
use App\PayPeriod;
use Carbon\Carbon;
use http\Url;
use App\Http\NavSoap\NTLMSoapClient;

class NavSyncManager{
    private $config;

    private $syncClasses;

    public static $NAV_HTTP_ERROR_CODE = 11002;

    public function __construct()
    {
        $this->config = include ('NavSyncConfig.php');
        $this->syncClasses = [
            Employee::class => ["endpoint" => $this->config->NAV_SOAP_EMPLOYEE, "search_fields" => ['No'] ],
            LeaveType::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_TYPES, "search_fields" => ['Code'] ],
            EmployeeLeaveAllocation::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_ALLOC, "search_fields" => ['Employee_No', 'Leave_Period'] ],
            EmployeeLeaveApplication::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_APPS, "search_fields" => ['Application_Code'] ],
            EmployeeApprover::class => ["endpoint" => $this->config->NAV_SOAP_APPROVERS, "search_fields" => ['Approver'] ],
            ApprovalEntry::class => ["endpoint" => $this->config->NAV_HR_APPROVALS, "search_fields" => ['Table_ID'] ],
            PayPeriod::class => ["endpoint" => $this->config->NAV_PAY_PERIODS, "search_fields" => [] ],
        ];
    }

    public function sendLeaveApplication(EmployeeLeaveApplication $application){

            $application = EmployeeLeaveApplication::find($application->id);

            if ($application->Web_Sync == 1) {

                $result = null;
                if (true) {
                    $result = $this->create($this->syncClasses[EmployeeLeaveApplication::class]["endpoint"], (object)$application->toArray());
                } else {
                    $search_fields = $this->syncClasses[EmployeeLeaveApplication::class]["search_fields"];
                    $filters = [];
                    foreach ($search_fields as $search_field) {
                        array_push($filters, $application[$search_field]);
                    }
                    $result = $this->update($this->syncClasses[EmployeeLeaveApplication::class]["endpoint"],
                        (object)$application->toArray(), $filters);
                }

                $new_application = (array)($result->LeaveApps);
                unset($new_application["Application_Code"]);
                $application->fill((array)$new_application);
                $application->Web_Sync = 0;
                $application->Web_Sync_TimeStamp = Carbon::now();
                $application->save();
                return $result;
            }
    }


    public function sendLeaveApprovals(ApprovalEntry $approvalEntry){
        $result = null;
            if ($approvalEntry->Web_Sync == 1) {
                $result = null;
                if (!$approvalEntry->Web_Sync_TimeStamp || true) {

                    $approvalEntry = $approvalEntry->toArray();
//                    unset($approvalEntry["Sender_ID"]);
//                    unset($approvalEntry["Document_Owner"]);

                    $result = $this->create($this->syncClasses[ApprovalEntry::class]["endpoint"], (object)$approvalEntry);
                } else {
                    $search_fields = $this->syncClasses[ApprovalEntry::class]["search_fields"];
                    $filters = [];
                    foreach ($search_fields as $search_field) {
                        array_push($filters, $approvalEntry[$search_field]);
                    }
                    $result = $this->update($this->syncClasses[ApprovalEntry::class]["endpoint"],
                        (object)$approvalEntry->toArray(), $filters);
                }
                $new_approval = (array)($result->HRApprovals);
                $id = $new_approval["Table_ID"];
                unset($new_approval["Table_ID"]);
                $approvalEntry = ApprovalEntry::where("Table_ID", $id)->first()->fill((array)$new_approval);
                $approvalEntry->Web_Sync = 0;
                $approvalEntry->Web_Sync_TimeStamp = Carbon::now();
                $approvalEntry->save();
            }
            return $result;
    }
    public function sync(){
        print ("\n");
        print ("--------------- NAV SYNCING STARTED -----------------\n");

        $this->pushTable(EmployeeLeaveApplication::class, $this->syncClasses[EmployeeLeaveApplication::class]["endpoint"]);


        print ("\n");
        print ("--------------- PULLING NAV DATA STARTED -----------------\n");
        foreach ($this->syncClasses as $model => $props){
            $this->getTable($model, $props["endpoint"], $props["search_fields"]);
        }
        print ("--------------- PULLING NAV DATA FINISHED -----------------\n");
        print ("\n");

        print ("\n");
        print ("--------------- CREATING NAV DATA STARTED -----------------\n");
        foreach ($this->syncClasses as $model => $props){
            $this->pushTable($model, $props["endpoint"]);
        }
        print ("--------------- CREATING NAV DATA FINISHED -----------------\n");
        print ("\n");

        print ("\n");
        print ("--------------- UPDATING NAV DATA STARTED -----------------\n");
        foreach ($this->syncClasses as $model => $props){
            $this->updateTable($model, $props["endpoint"], $props["search_fields"]);
        }
        print ("--------------- UPDATING NAV DATA FINISHED -----------------\n");
        print ("\n");


        $employees = $this->get($this->config->NAV_SOAP_EMPLOYEE)->Employees;
        foreach ($employees as $employee){
            print ("Profile Pic for: $employee->No");
            $encoded_image = $this->getProfilePic($this->config->NAV_SOAP_PROFILE_PIC, ["empNo" => $employee->No]);

            $instance = Employee::where('No', $employee->No)->first();
            if (!$instance->saveProfilePic($encoded_image)) print "Failed to save prof pic\n";
            print ("\n\n");
        }





        print ("--------------- NAV SYNCING ENDED -----------------");
        print ("\n\n");
    }


    public function pushTable($model, $endpoint){
        try {
            $records = $model::where(['Nav_Sync' => 0, 'Nav_Sync_TimeStamp' => null])->get();

            foreach ($records as $record) {
                try {
                    $result = (array)$this->create($endpoint, (object)$record->toArray());

                    $record->fill(reset($result));
                    $record->Nav_Sync = false;
                    $record->Nav_Sync_TimeStamp = date("Y-m-d");
                    $record->save();
//                print ("success");
                } catch (\Exception $e) {
                    print ($e->getMessage() . "\n\n");
//                print ($e);
                }

            }
        }
        catch (\Exception $e){
            print $e->getMessage();
        }
    }

    public function updateTable($model, $endpoint, $filters)
    {

        print ("\n");
        print ("--------------- STARTED UPDATING $endpoint -----------------\n");

        try {
            $records = $model::where('Nav_Sync', 0)->whereNotNull('Nav_Sync_TimeStamp')->get();
            foreach ($records as $record) {
                try {

                    $filter_array = [];

                    foreach ($filters as $filter) {
                        $filter_array[$filter] = $record[$filter];
                    }
                    $this->update($endpoint, $record->toArray(), $filter_array);

                    $record->Web_Sync = false;
                    $record->Web_Sync_TimeStamp = date("Y-m-d");
                    $record->save();
                } catch (\Exception $e) {
                    print ($e->getMessage() . "\n\n");
                }
            }
        }
        catch (\Exception $e){print $e->getMessage();}

        print ("--------------- FININSHED UPDATING $endpoint -----------------\n");
        print ("\n");
    }

    public function getTable($model, $endpoint, $search_fields){

        try {

            print ("\n\n");
            print ("--------------- SNYNCING $endpoint ---------------\n");

            if ($model::all()->isEmpty()) {
                $records = get_object_vars($this->get($endpoint));

            } else {
                try{
                    $records = get_object_vars($this->get($endpoint, null, ['Web_Sync' => 0]));
                }catch (\Exception $e){

                    $records = get_object_vars($this->get($endpoint, null, []));

                }
            }


            $records = reset($records);
            if (!$records) return;
            foreach ($records as $record) {

                try {
                    $instance = new $model();
                    $data = (array)$record;
                    try {
                        unset($data["Key"]);
                    } catch (\Exception $e) {

                    };
                    $instance->fill($data);
                    $instance->Nav_Sync = True;
                    $instance->Web_Sync = True;
                    $instance->save();

                    // Set NAV Synced to True NAV
                    $filters = array_flip($search_fields);
                    array_walk($filters, function (&$var, $key) use ($instance) {
                        $var = $instance[$key];
                    });
                    $this->update($endpoint, $instance, $filters);


                } catch (\Exception $e) {
                    print ($e->getMessage() . "\n");
                }
            }
        }catch (\Exception $e){
            print ($e);
        }

        print ("\n\n");
        print ("--------------- END SNYNCING $endpoint ---------------\n");
    }

    public function get($endpoint,array $params= null, array $filters = null, $callback = null){
        $url = $this->config->NAV_BASE_URL."/$endpoint";
        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);

        if($params){
            return $client->Read($params)->Item;
        }

        $criteria = array();
        if($filters){
            foreach ($filters as $key => $value){
                array_push($criteria, ["Field" => $key, "Criteria" => $value]);
            }
        }

        $res =  $client->ReadMultiple(['filter' => $criteria, 'setSize'=> 0])->ReadMultiple_Result;
        $this->restoreWrapper();
        return $res;
    }

    public function create($endpoint, $data){
        $url = $this->config->NAV_BASE_URL."/$endpoint";

        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);
        $resource_name = explode("/", $endpoint);
        $resource_name = end($resource_name);
        $update = [$resource_name => (object)$data];
        $result =  $client->Create((object)$update);
        $this->restoreWrapper();
        return $result;
    }

    /**
     * The endpoint of the NAV resource
     * @param $endpoint
     * Should be of type stdClass  with property names as fields
     * @param $data
     * any filters for the record you are updating
     * @param $filters
     * @return mixed
     */
    public function update($endpoint, $data, $filters){
        $url = $this->config->NAV_BASE_URL."/$endpoint";
        $record = (array)$this->get($endpoint, null, $filters);
        $record = (array)reset( $record);

        array_walk($record, function (&$var, $key) use($data, $record){
            try{
                if($data[$key]){
                    $var = $data[$key];
                }
            } catch (\Exception $e){
                print ($e->getMessage());
            }
        });

        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);
        $resource_name = explode("/", $endpoint);
        $resource_name = end($resource_name);
        $update = [$resource_name => (object)$record];

        $res =  $client->Update((object)$update);
        $this->restoreWrapper();
        return $res;

    }


    public  function delete($enponint, $key){

    }

    public function getProfilePic($endpoint,Array $params)
    {
        $url = $this->config->NAV_BASE_URL . "/$endpoint";
        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);


        $res =  $client->GetEmployeePic($params)->return_value;
        $this->restoreWrapper(); return $res;
    }

    public function getPayslip(Employee $employee, $period)
    {
        $url = $this->config->NAV_BASE_URL . "/". $this->config->NAV_PAYSLIP_URL;
        $this->prepareWrapper();
        $client = new NTLMSoapClient($url,['trace' => 1]);
        $params = [
            "returnString" => null,
            "employee_Code" => $employee->No,
            "payroll_Period" => $period
        ];
        $res =  $client->ProcessBlobs($params)->returnString;
        $this->restoreWrapper();
        return $res;
    }

    public function prepareWrapper(){
        stream_wrapper_unregister('http');
        stream_wrapper_register('http', NTLMStream::class) or die("Failed to register protocol");
    }

    public function calculateLeaveDates(
        $leaveTypeCode, $employeeCode, $baseCalendarCode, $sDate, $eDate){
        $url = $this->config->NAV_BASE_URL."/".$this->config->NAV_SOAP_LEAVE_MANAGER;

        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);

        $data = (object)[
                "leaveAppCode" => $leaveTypeCode,
                "leaveEmployee" => $employeeCode,
                "baseCalendarCode" => $baseCalendarCode,
                "sDate" => $sDate,
                "lDays" => 0,
                "eDate" => $eDate,
                "rDate" => date("Y-m-d"),

        ];

//       print_r($data);
        $result = $client->CalculateLeaveDatesWeb($data);

//        if($result->return_value != 0 && $result->return_value != 1){
//            throw new NavHttpException($this->config->NAV_SOAP_LEAVE_MANAGER_CODES[$result->return_value], static::$NAV_HTTP_ERROR_CODE);
//        }
//      print_r($result);
        $this->restoreWrapper();
        return $result;
    }

    public function restoreWrapper(){
        stream_wrapper_restore('http');
    }

}

class NavHttpException extends \Exception {
}