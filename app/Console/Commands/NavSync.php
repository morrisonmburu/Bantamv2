<?php

namespace App\Console\Commands;

use App\Http\NavSoap\NavSyncManager;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use \App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $syncManager = new NavSyncManager();
            $syncManager->sync();
        }
        catch (\Exception $e){
            print ($e);
        }
        return;
    }
}
