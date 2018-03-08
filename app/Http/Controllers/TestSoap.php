<?php

namespace App\Http\Controllers;
use App\Http\NavSoap\NTLMStream;
use App\Http\NavSoap\NTLMSoapClient;
use GuzzleHttp\Client;

class TestSoap extends Controller
{
    public function test(){
        try {
            $url = 'http=>//192.168.88.241=>7447/DynamicsKISM/WS/KISM/Page/Employee';
            // we unregister the current HTTP wrapper
            stream_wrapper_unregister('http');
            // we register the new HTTP wrapper
            stream_wrapper_register('http', NTLMStream::class) or die("Failed to register protocol");
            // so now all request to a http page will be done by MyServiceProviderNTLMStream.
            // ok now, let's request the wsdl file
            // if everything works fine, you should see the content of the wsdl file
            $client = new NTLMSoapClient($url,['trace' => 1]);


            //Read Multiple Records
            try{
                $params = array('filter' => array( array('Field' => 'No',
                    'Criteria' => '')
                ),
                    'setSize' => 10); //setSize =0 will return all rows - Can cause performance issue with large results set!
                $result = $client->ReadMultiple($params);
                $resultSet = $result->ReadMultiple_Result->Employee;

                echo "Read Multiple Records Result=><br>";
                if (is_array($resultSet)) {
                    foreach($resultSet as $rec) {
                        echo $rec->No . "&nbsp;" ."<br>";
                    }
                }
                else {
                    echo $resultSet->No . "&nbsp;" . $resultSet->First_Name."<br>";
                }
            }
            catch (Exception $e) {
                echo "<hr><b>ERROR=> SoapException=></b> [".$e."]<hr>";
                echo "<pre>".htmlentities(print_r($client->__getLastRequest(),1))."</pre>";
            }

            // restore the original http protocole
            stream_wrapper_restore('http');
        }catch(Exception $e) {
            echo $e;
        }
    }

    public function odataTest(){
        $client = new Client(['base_uri' => 'http=>//192.168.88.241=>7448/DynamicsKISM/OData/Company(\'KISM\')/']);
        $resp=$client->request("GET","Employee",[
            'headers' => ['Accept' => 'application/json'],
            'auth' => ['michael.kamau', 'Pass@2018',"NTLM"]
        ]);

        $employees =json_decode( $resp->getBody()->getContents());

        foreach ($employees->value as $employee){
            dd($employee);
            echo $employee->No . "&nbsp;" . $employee->First_Name."<br>";
        }
        
        $data=["No"=>"A1001",
        "Job_Title"=> "Software Dev",
        "First_Name"=> "Donnicias",
        "Last_Name"=> "Mayaka",
        "Middle_Name"=> "",
        "Initials"=> "Mr",
        "Address"=> "35",
        "Address_2"=> "Nairobi",
        "Post_Code"=> "60401",
        "City"=> "CHOGORIA",
        "Base_Calendar"=> "KISM",
        "Country_Region_Code"=> "KENYA",
        "Phone_No"=> "0705777958",
        "Search_Name"=> "MS",
        "Gender"=> "Female",
        "Last_Date_Modified"=> "2017-03-14T00=>00=>00",
        "Extension"=> "108",
        "Mobile_Phone_No"=> "0705777958",
        "Pager"=> "",
        "E_Mail"=> "mayakadonnicias@gmail.com",
        "Company_E_Mail"=> "mayakadonnicias@kism.or.ke",
        "Alt_Address_Code"=> "",
        "Alt_Address_Start_Date"=> "0001-01-01T00=>00=>00",
        "Alt_Address_End_Date"=> "0001-01-01T00=>00=>00",
        "PIN_No"=> "",
        "NSSF_No"=> "",
        "Employment_Date"=> "2017-02-13T00=>00=>00",
        "Status"=> "Active",
        "Inactive_Date"=> "2017-06-01T00=>00=>00",
        "Cause_of_Inactivity_Code"=> "",
        "Termination_Date"=> "0001-01-01T00=>00=>00",
        "Grounds_for_Term_Code"=> "",
        "Emplymt_Contract_Code"=> "04",
        "Statistics_Group_Code"=> "",
        "Resource_No"=> "",
        "Salespers_Purch_Code"=> "",
        "User_ID"=> "12",
        "Customer_Code"=> "SC1450",
        "Birth_Date"=> "1993-12-04T00=>00=>00",
        "Social_Security_No"=> "",
        "Union_Code"=> "",
        "Union_Membership_No"=> ""];
    }
}
