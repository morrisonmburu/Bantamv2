<?php

namespace App\Console\Commands;

use App\ApprovalEntry;
use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use \App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class NavTest extends Command
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
    protected $signature = 'nav:test';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Testing NAV sync';

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
            $entry = ApprovalEntry::find(1);
            $entry->Nav_Sync = 1;
            $entry->save();
//            $manager = new NavSyncManager();
//            $manager->sendLeaveApplication($entry);
        }
        catch (\Exception $e){
            print ($e);
        }
        return;
    }
}
