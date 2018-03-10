<?php

namespace App\Listeners;

use App\Employee;
use App\Events\EmployeeCreated;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class EmployeeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmployeeCreated  $event
     * @return void
     */
    public function handle(Employee $employee)
    {
        $user = new User();
        $user->password = Hash::make(uniqid());
        $user->email = $employee->E_Mail;
        $user->name = "$employee->First_Name $employee->Last_Name";
        $user->save();

        $employee->user_id = $user->id;
        $employee->save();
        $credentials = ['email' => $user->email];
        $response = Password::sendResetLink($credentials, function ($message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                $user->activation_link_sent = true;
                return true;
            default:
                return false;

        }
    }
}
