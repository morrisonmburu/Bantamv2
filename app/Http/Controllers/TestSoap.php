<?php

namespace App\Http\Controllers;
use App\Http\NavSoap\NTLMStream;
use App\Http\NavSoap\NTLMSoapClient;
use GuzzleHttp\Client;
use App\Http\Controllers\EmployeeController;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
class TestSoap extends Controller
{
    public function test()
    {
        try {
            $url = 'http://192.168.88.241:9347/NAVDEMO/WS/CRONUS%20International%20Ltd./Page/Employees';
            // we unregister the current HTTP wrapper
            stream_wrapper_unregister('http');
            // we register the new HTTP wrapper
            stream_wrapper_register('http', NTLMStream::class) or die("Failed to register protocol");
            // so now all request to a http page will be done by MyServiceProviderNTLMStream.
            // ok now, let's request the wsdl file
            // if everything works fine, you should see the content of the wsdl file
            $client = new NTLMSoapClient($url, ['trace' => 1]);


            //Read Multiple Records
            try {
                $params = array('filter' => array(array('Field' => 'No',
                    'Criteria' => '')
                ),
                    'setSize' => 10); //setSize =0 will return all rows - Can cause performance issue with large results set!
                $result = $client->ReadMultiple($params);
                $resultSet = $result->ReadMultiple_Result->Employee;

                echo "Read Multiple Records Result=><br>";
                if (is_array($resultSet)) {
                    foreach ($resultSet as $rec) {
                        echo $rec->No . "&nbsp;" . "<br>";
                    }
                } else {
                    echo $resultSet->No . "&nbsp;" . $resultSet->First_Name . "<br>";
                }
            } catch (Exception $e) {
                echo "<hr><b>ERROR=> SoapException=></b> [" . $e . "]<hr>";
                echo "<pre>" . htmlentities(print_r($client->__getLastRequest(), 1)) . "</pre>";
            }

            // restore the original http protocole
            stream_wrapper_restore('http');
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function odataTest(){
        // ============ Instantiating Client ================ //
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json','Accept' => 'application/json' ],
            'auth' => ['michael.kamau', 'Pass@2018',"NTLM"],
            'proxy' => 'http://localhost:8888'
        ]);
        // ==============End of instantiating Client ==================//

        $data2=[
            "Job_Title"=> "Software Dev",
            "First_Name"=> "Micahel",
            "E_Mail"=> "mayakadonnicias@gmail.com",
            "Last_Name"=> "Kamau"];
//================== Creating A record =================//
//        try{
//            $response = $client->post('http://192.168.88.241:7448/DynamicsKISM/OData/Company(\'KISM\')/Employee',
//                ['body' => json_encode($data2)]
//            );
//
//            echo($response->getBody());
//        }catch (RequestException $e){
//            dd($e);
//        }
// ====================== End creating a record ============//


        $resp=$client->request("GET","http://192.168.88.241:7448/DynamicsKISM/OData/Company('KISM')/Employee"); // Returns all Employees
        $resp2=$client->request("GET","http://192.168.88.241:7448/DynamicsKISM/OData/Company('KISM')/Employee?\$filter=No eq 'A0010'"); // Searches where No=A0010

        $employees =json_decode( $resp->getBody()->getContents());

        foreach ($employees->value as $employee){
            //dd($employee);
            echo $employee->No . "&nbsp;" . $employee->First_Name."<br>";
        }
        

    }

    public function ImageTest(){
        $path = "img/a2.jpg";
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


        $data = explode( ',', $base64 );

        echo $data[0]."<br/>";
        echo $data[1];
//        $decodedFile=base64_decode($base64);
//
//        $file=file_put_contents("img/myImage.jpg",$decodedFile);
//        return $file;
    }

    function getProfilePic($base64_image_string, $imageFileName, $path="Profile_Pictures/" ) {
        $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
        $mime=$splited[0];
        $data=$splited[1];

        $mime_split_without_base64=explode(';', $mime,2);
        $mime_split=explode('/', $mime_split_without_base64[0],2);
        if(count($mime_split)==2)
        {
            $extension=$mime_split[1];
            if($extension=='jpeg')$extension='jpg';
            $output_file_with_extension=$imageFileName.'.'.$extension;
        }
        file_put_contents( $path . $output_file_with_extension, base64_decode($data) );
        return $output_file_with_extension;
    }
}
