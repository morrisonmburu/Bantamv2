<?php
namespace App\Http\NavSoap;
use App\Employee;
use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NTLMStream;
use App\LeaveType;
use http\Url;
use App\Http\NavSoap\NTLMSoapClient;

class NavSyncManager{
    private $config;

    private $syncClasses;

    public function __construct()
    {
        $this->config = include ('NavSyncConfig.php');

        $this->syncClasses = [
            Employee::class => ["endpoint" => $this->config->NAV_SOAP_EMPLOYEE, "search_fields" => ['No'] ],
            LeaveType::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_TYPES, "search_fields" => ['Code'] ],
            EmployeeLeaveAllocation::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_ALLOC, "search_fields" => ['Employee_No', 'Leave_Period'] ],
            EmployeeLeaveApplication::class => ["endpoint" => $this->config->NAV_SOAP_LEAVE_APPS, "search_fields" => ['Application_Code'] ],

        ];
    }

    public function sync(){
        print ("\n");
        print ("--------------- NAV SYNCING STARTED -----------------\n");
//        $employees = $this->get($this->config->NAV_SOAP_EMPLOYEE)->Employees;
//        foreach ($employees as $employee){
//            print ("Profile Pic for: $employee->First_Name $employee->Last_Name");
//            print_r($this->getProfilePic($this->config->NAV_SOAP_PROFILE_PIC, ["empNo" => $employee->No]));
//            print ("\n\n");
//        }
        foreach ($this->syncClasses as $model => $props){
            $this->syncTable($model, $props["endpoint"], $props["search_fields"]);
        }

        print ("--------------- NAV SYNCING ENDED -----------------");
        print ("\n\n");
    }

    public function syncTable($model, $endpoint, $search_fields){
        $records = get_object_vars($this->get($endpoint));
        $records = reset($records);
        foreach ($records as $record){

            try{
                $instance = new $model();
                $data = (array)$record;
                try{
                    unset($data["Key"]);
                }
                catch (\Exception $e){

                };
                $instance->fill($data);
                $instance->Nav_Sync = True;
                $instance->Web_Sync = True;
                $instance->save();

                // Set NAV Synced to True NAV
                $filters = array_flip($search_fields);
                array_walk($filters,function (&$var, $key) use($instance){
                    $var = $instance[$key];
                });
                $this->update($endpoint, $instance, $filters);


            }
            catch (\Exception $e){
                print ($e->getMessage()."\n");
            }
        }
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

    public function create($enpoint, $data){

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

    public function restoreWrapper(){
        stream_wrapper_restore('http');
    }

}