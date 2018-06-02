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
use Symfony\Component\Debug\Exception\FatalThrowableError;

class NavSyncManager{
    private $config;

    private $syncClasses;

    public static $NAV_HTTP_ERROR_CODE = 11002;

    public function __construct()
    {
        $this->config = include ('NavSyncConfig.php');
        $this->syncClasses = [
            Employee::class => ["endpoint" => $this->config->NAV_SOAP_EMPLOYEE, "search_fields" => ['No'] ],
            LeaveType::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_TYPES, "search_fields" => ['Code'], "update" => false ],
            EmployeeLeaveAllocation::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_ALLOC, "search_fields" => ['Employee_No', 'Leave_Period'], "update" => false ],
            EmployeeLeaveApplication::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_APPS, "search_fields" => ['Application_Code'] ],
            EmployeeApprover::class => ["endpoint" => $this->config->NAV_SOAP_APPROVERS, "search_fields" => ['Approver', 'Employee', 'Approval_Level'] ],
            ApprovalEntry::class => ["endpoint" => $this->config->NAV_HR_APPROVALS, "search_fields" => ['Document_No', 'Approver_ID', 'Document_Type', 'Sequence_No'] ],
            PayPeriod::class => ["endpoint" => $this->config->NAV_PAY_PERIODS, "search_fields" => ['Starting_Date', 'Name'], "update" => false ],
        ];
    }

    public function sendLeaveApplication(EmployeeLeaveApplication $application){

            $application = EmployeeLeaveApplication::find($application->id);

            if ($application->Web_Sync == 1) {

                $result = null;
                if (!$application->Web_Sync_TimeStamp) {
                    $result = $this->create($this->syncClasses[EmployeeLeaveApplication::class]["endpoint"], $application->toArray());
                } else {
                    $search_fields = $this->syncClasses[EmployeeLeaveApplication::class]["search_fields"];
                    $filters = [];
                    foreach ($search_fields as $search_field) {
                        $filters[$search_field] =  $application[$search_field];
                    }
                    $result = $this->update($this->syncClasses[EmployeeLeaveApplication::class]["endpoint"],
                        $application->toArray(), $filters);
                }

                $new_application = (array)($result->LeaveApps);
                print_r($new_application);
                unset($new_application["Application_Code"]);
                unset($new_application["Web_Sync_TimeStamp"]);
                unset($new_application["Web_Sync"]);
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
                if (!$approvalEntry->Web_Sync_TimeStamp ) {
                    $result = $this->create($this->syncClasses[ApprovalEntry::class]["endpoint"], $approvalEntry->toArray());
                } else {
                    $search_fields = $this->syncClasses[ApprovalEntry::class]["search_fields"];
                    $filters = [];
                    foreach ($search_fields as $search_field) {
                        $filters[$search_field] =  $approvalEntry[$search_field];
                    }
                    $result = $this->update($this->syncClasses[ApprovalEntry::class]["endpoint"],
                        $approvalEntry->toArray(), $filters);
                }
                $new_approval = (array)($result->HRApprovals);
                unset($new_approval["Web_Sync_TimeStamp"]);
                unset($new_approval["Web_Sync"]);
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
            if( isset($this->syncClasses[$model]["update"]) && !$this->syncClasses[$model]["update"]) return;
            $records = $model::where(['Web_Sync' => 1, 'Web_Sync_TimeStamp' => null])->get();

            foreach ($records as $record) {
                try {
                    $result = (array)$this->create($endpoint, (object)$record->toArray());

                    $record->fill((array)reset($result));
                    $record->Web_Sync = false;
                    $record->Web_Sync_TimeStamp = Carbon::now();
                    $record->save();
                    print ("Successfully created ".$model." in NAV\n");
                } catch (\Exception $e) {
                    print ($e->getMessage() . "\n\n");
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

            if( isset($this->syncClasses[$model]["update"]) && !$this->syncClasses[$model]["update"]) return;
            $records = $model::where('Web_Sync', 1)->whereNotNull('Web_Sync_TimeStamp')->get();
            foreach ($records as $record) {
                try {

                    $filter_array = [];

                    foreach ($filters as $filter) {
                        $filter_array[$filter] = $record[$filter];
                    }
                    $this->update($endpoint, $record->toArray(), $filter_array);

                    $record->Web_Sync = false;
                    $record->Web_Sync_TimeStamp = date("Y-m-d");
                    print ("Successfully updated ".$model." in NAV\n");
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
                    $records = get_object_vars($this->get($endpoint, null, ['Nav_Sync' => true]));
                }catch (\Exception $e){

                    $records = get_object_vars($this->get($endpoint, null, []));

                }
            }

            $records = reset($records);
            if (!$records) return;
            $records = is_array($records) ? $records : [$records];
            foreach ($records as $record) {

                try {
                    $instance = new $model();
                    $data = (array)$record;
                    try {
                        unset($data["Key"]);
                    } catch (\Exception $e) {

                    };
                    $instance->fill($data);

                    try{
                        $instance->save();
                    }catch (\Exception $e){
                        if($e->getCode() == "23000"){
                            try {
                                $filter_array = [];
                                $filters = $this->syncClasses[$model]['search_fields'];
                                foreach ($filters as $filter) {
                                    $filter_array[$filter] = $data[$filter];
                                }
                                $instance = $model::where($filter_array)->first();
                                $instance->fill($data);
                                $instance->save();
                            }
                            catch (\Throwable $t){ continue;}

                        }
                    }

                    $instance->Web_Sync = false;
                    $instance->Nav_Sync = false;
                    $instance->Web_Sync_TimeStamp = Carbon::now();
                    $instance->save();


                    if( isset($this->syncClasses[$model]["update"]) && !$this->syncClasses[$model]["update"]) continue;
                    // Set NAV Synced to True NAV
                    $filters = array_flip($search_fields);
                    array_walk($filters, function (&$var, $key) use ($instance) {
                        $var = $instance[$key];
                    });
                    $this->update($endpoint, $instance->toArray(), $filters);


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
        $data = (array) $data;
        unset($data["Web_Sync_TimeStamp"]);
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
        array_walk($data, function (&$var, $key) use($data, &$record){
            try{
                $record[$key] = $var;
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

        if($result->return_value != 0 && $result->return_value != 1){
            throw new NavHttpException($this->config->NAV_SOAP_LEAVE_MANAGER_CODES[$result->return_value], static::$NAV_HTTP_ERROR_CODE);
        }
        $this->restoreWrapper();
        return $result;
    }

    public function restoreWrapper(){
        stream_wrapper_restore('http');
    }
}

class NavHttpException extends \Exception {
}