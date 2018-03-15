<?php

namespace App\Providers;

use App\Employee;
use App\EmployeeLeaveAllocation;
use App\EmployeeLeaveApplication;
use App\Policies\EmployeeLeaveAllocationPolicy;
use App\Policies\EmployeeLeaveApplicationPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Employee::class => EmployeePolicy::class,
        User::class => UserPolicy::class,
        EmployeeLeaveAllocation::class => EmployeeLeaveAllocationPolicy::class,
        EmployeeLeaveApplication::class => EmployeeLeaveApplicationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
