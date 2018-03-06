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
        $this->NAV_ENDPOINT = "";
        $this->NAV_PWD = env("NAV_PWD");
        $this->NAV_USER = env("NAV_USER");

        $this->client = new Client('{base_endpoint}', array(
            'base_endpoint' => $this->NAV_ENDPOINT,
            'request.options' => array(
                'headers' => array('Accept' => 'Applicatiion/json'),
                'auth'    => array($this->NAV_USER, $this->NAV_PWD, 'Basic|Digest|NTLM|Any')
            )
        ));
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


        fopen(__DIR__ . "/log.txt", "w") ;
    }
}
