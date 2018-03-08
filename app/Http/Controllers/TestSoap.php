<?php

namespace App\Http\Controllers;
use App\Http\NavSoap\NTLMStream;
use App\Http\NavSoap\NTLMSoapClient;

class TestSoap extends Controller
{
    public function test(){
        try {
            $url = 'http://192.168.88.241:7447/DynamicsKISM/WS/KISM/Page/Employee';
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

                echo "Read Multiple Records Result:<br>";
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
                echo "<hr><b>ERROR: SoapException:</b> [".$e."]<hr>";
                echo "<pre>".htmlentities(print_r($client->__getLastRequest(),1))."</pre>";
            }

            // restore the original http protocole
            stream_wrapper_restore('http');
        }catch(Exception $e) {
            echo $e;
        }
    }
}
