<?php

namespace App\Policies;

use App\Employee;
use App\User;
use App\EmployeeLeaveAllocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeLeaveAllocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the employeeLeaveAllocation.
     *
     * @param  \App\User  $user
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return mixed
     */
    public function view(User $user, EmployeeLeaveAllocation $employeeLeaveAllocation)
    {
        if($user->Employee_Record && $user->Employee_Record->No == $employeeLeaveAllocation->employee->No){
            return true;
        }

        if($employeeLeaveAllocation->employee->employee_approvers->contains($user->Employee_Record)){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create employeeLeaveAllocations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the employeeLeaveAllocation.
     *
     * @param  \App\User  $user
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return mixed
     */
    public function update(User $user, EmployeeLeaveAllocation $employeeLeaveAllocation)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the employeeLeaveAllocation.
     *
     * @param  \App\User  $user
     * @param  \App\EmployeeLeaveAllocation  $employeeLeaveAllocation
     * @return mixed
     */
    public function delete(User $user, EmployeeLeaveAllocation $employeeLeaveAllocation)
    {
        return false;
    }

    public function index(User $user)
    {
        return false;
    }

    public function employee(User $user, Employee $employee)
    {
        if($user->Employee_Record && $user->Employee_Record->No == $employee->No){
            return true;
        }
        if($employee->employee_approvers->contains($user->Employee_Record)){
            return true;
        }
        return false;
    }

}
