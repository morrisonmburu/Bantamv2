<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use \App\Employee;


class NavSync extends Command
{

    private $NAV_ENDPOINT;
    private $NAV_USER;
    private $NAV_PWD;
    private $client;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nav:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs bantam data with NAV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->NAV_ENDPOINT = "http://192.168.88.241:7448/DynamicsKISM/OData/Company('KISM')/";
        $this->NAV_PWD = env("NAV_PWD");
        $this->NAV_USER = env("NAV_USER");

        $this->client = new Client(['base_uri' =>$this->NAV_ENDPOINT]);
    }

    /**
     * The endpoint of the resource
     * @param $endpoint
     */
    private function get($resource){
        $this->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Sync Employee Data
        $file = fopen(__DIR__ . "/data.txt", "w") ;
        try{

            $response = $this->client->request('GET', 'Employee', [
                'headers'        => ['Accept' => 'application/json'],
                'auth'    => array($this->NAV_USER, $this->NAV_PWD, 'NTLM')
            ]);
            $jsonResponse = $response->getBody()->getContents();
            $decodedResonse = json_decode($jsonResponse, true);
            array_walk_recursive($decodedResonse, function (& $item, $key) {if (is_null($item) || trim($item) == '') { $item = NULL; }});
            foreach($decodedResonse['value'] as $emp){
                $employee = new Employee();
                $employee->fill($emp);
                $employee->save();
            }
            fwrite($file, "success");
        }
        catch (\Exception $e){
            fwrite($file, $e->getCode());
        }

        fclose($file);
    }
}
