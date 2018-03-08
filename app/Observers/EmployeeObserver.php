<?php

namespace App\Observers;

use App\User;
use App\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(Employee $employee)
    {
        $user = new User();

    }
}