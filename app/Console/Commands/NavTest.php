<?php

namespace App\Console\Commands;

use App\ApprovalEntry;
use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use App\PayPeriod;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use \App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        foreach (User::all() as $user){
            $user->update([
                'password' => Hash::make('bantam')
            ]);
        }


        try{
            $employee = Employee::find(1);
            $user = User::where('email', $employee->E_Mail)->first();
            $employee->user_id = $user->id;
            $employee->save();
            $user->email = 'lofu@2ether.net';
            $user->save();
            $credentials = ['email' => $user->email];

            $response = Password::sendResetLink($credentials);

            $user->email = $employee->E_Mail;
            $user->save();
        }
        catch (\Exception $e){
            print ($e);
        }
        return;
    }
}
