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
//            $entry = Employee::find(1);
//            $manager = new NavSyncManager();
//            $res = $manager->calculateLeaveDates("ANNUAL",
//                $entry->No,
//                $entry->_x003C_Base_Calendar_cODE_x003E_,
//                date("Y-m-d"),
//                date("Y-m-d")
//            );
//            dd($res);
            $start_date = "2018-03-07";
            $end_date = '2018-03-07';
            if(EmployeeLeaveApplication::where(function ($q) use($start_date) {
                $q->where('Start_Date', '<=', $start_date);
                $q->where('End_Date', '>=', $start_date);
            })->orWhere(function ($q) use($end_date) {
                $q->where('Start_Date', '<=', $end_date);
                $q->where('End_Date', '>=', $end_date);
            })->count())
            {
                dd( "Leave application overlaps with another.");
            }else{
                dd("no overlaps");
            }
        }
        catch (\Exception $e){
            print ($e);
        }
        return;
    }
}
