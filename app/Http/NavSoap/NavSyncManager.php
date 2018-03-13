<?php
namespace App\Http\NavSoap;
use App\ApprovalEntry;
use App\Employee;
use App\EmployeeApprover;
use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NTLMStream;
use App\LeaveType;
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
        ];
    }

    public function sendLeaveApplication(EmployeeLeaveApplication $application){
        $this->create($this->syncClasses[EmployeeLeaveApplication::class]["endpoint"], (object) $application->toArray());
        $application->Nav_Sync = false;
        $application->Nav_Sync_TimeStamp = date("Y-m-d");
        $application->save();

    }

    public function sync(){
        print ("\n");
        print ("--------------- NAV SYNCING STARTED -----------------\n");

        $this->pushTable(EmployeeLeaveApplication::class, $this->syncClasses[EmployeeLeaveApplication::class]["endpoint"]);
        foreach ($this->syncClasses as $model => $props){
            $this->getTable($model, $props["endpoint"], $props["search_fields"]);
        }

        $employees = $this->get($this->config->NAV_SOAP_EMPLOYEE)->Employees;
        foreach ($employees as $employee){
            print ("Profile Pic for: $employee->First_Name $employee->Last_Name");
            $encoded_image = $this->getProfilePic($this->config->NAV_SOAP_PROFILE_PIC, ["empNo" => $employee->No]);

            $instance = Employee::where('No', $employee->No)->first();
            if (!$instance->saveProfilePic($encoded_image)) print "Failed to save prof pic\n";
            print ("\n\n");
        }


        print ("--------------- NAV SYNCING ENDED -----------------");
        print ("\n\n");
    }


    public function pushTable($model, $endpoint){
        $records = $model::where('Nav_Sync', false)->get();

        foreach ($records as $record){
            try{
                $this->create($endpoint, (object) $record->toArray());

                $record->Nav_Sync = false;
                $record->Nav_Sync_TimeStamp = date("Y-m-d");
                $record->save();
//                print ("success");
            }
            catch (\Exception $e){
                print ($e->getMessage()."\n\n");
//                print ($e);
            }

        }
    }

    public function getTable($model, $endpoint, $search_fields){

        try {


            print ("\n\n");
            print ("--------------- SNYNCING $endpoint ---------------\n");

            if ($model::all()->isEmpty()) {
                $records = get_object_vars($this->get($endpoint));
            } else {
                $records = get_object_vars($this->get($endpoint, null, ['Web_Sync' => 0]));
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

        return $client->ReadMultiple(['filter' => $criteria, 'setSize'=> 0])->ReadMultiple_Result;
    }

    public function create($endpoint, $data){
        $url = $this->config->NAV_BASE_URL."/$endpoint";

        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);
        $resource_name = explode("/", $endpoint);
        $resource_name = end($resource_name);
        $update = [$resource_name => (object)$data];
        return $client->Create((object)$update);
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
        $record = reset( $record);

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

        return $client->Update((object)$update);

    }


    public  function delete($enponint, $key){

    }

    public function getProfilePic($endpoint,Array $params)
    {
        $url = $this->config->NAV_BASE_URL . "/$endpoint";
        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);


        return $client->GetEmployeePic($params)->return_value;

    }
    public function prepareWrapper(){
        stream_wrapper_unregister('http');
        stream_wrapper_register('http', NTLMStream::class) or die("Failed to register protocol");
    }

    public function calculateLeaveDates(
        $leaveTypeCode, $employeeCode, $baseCalendarCode, $sDate, $lDays){
        $url = $this->config->NAV_BASE_URL."/".$this->config->NAV_SOAP_LEAVE_MANAGER;

        $this->prepareWrapper();
        $client = new NTLMSoapClient($url, ['trace' => 1]);

        $data = (object)[
                "leaveAppCode" => $leaveTypeCode,
                "leaveEmployee" => $employeeCode,
                "baseCalendarCode" => $baseCalendarCode,
                "sDate" => $sDate,
                "lDays" => $lDays,
                "eDate" => date("Y-m-d"),
                "rDate" => date("Y-m-d"),

        ];

//       print_r($data);
        $result = $client->CalculateLeaveDates($data);

//        if($result->return_value != 0 && $result->return_value != 1){
//            throw new NavHttpException($this->config->NAV_SOAP_LEAVE_MANAGER_CODES[$result->return_value], static::$NAV_HTTP_ERROR_CODE);
//        }
//      print_r($result);
        return $result;
    }

    public function restoreWrapper(){
        stream_wrapper_restore('http');
    }

}

class NavHttpException extends \Exception {
}