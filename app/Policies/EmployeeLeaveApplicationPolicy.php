<?php

namespace App\Policies;

use App\Employee;
use App\User;
use App\EmployeeLeaveApplication;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeLeaveApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the employeeLeaveApplication.
     *
     * @param  \App\User  $user
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return mixed
     */
    public function view(User $user, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        if($user->Employee_Record && $user->Employee_Record->No == $employeeLeaveApplication->employee->No){
            return true;
        }

        if($employeeLeaveApplication->employee->employee_approvers->contains($user->Employee_Record)){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create employeeLeaveApplications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->Employee_Record ? true: false;
    }

    /**
     * Determine whether the user can update the employeeLeaveApplication.
     *
     * @param  \App\User  $user
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return mixed
     */
    public function update(User $user, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        if($user->Employee_Record && $user->Employee_Record->No == $employeeLeaveApplication->employee->No){
            return true;
        }
        if($employeeLeaveApplication->employee->employee_approvers->contains($user->Employee_Record)){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the employeeLeaveApplication.
     *
     * @param  \App\User  $user
     * @param  \App\EmployeeLeaveApplication  $employeeLeaveApplication
     * @return mixed
     */
    public function delete(User $user, EmployeeLeaveApplication $employeeLeaveApplication)
    {
        return $user->Employee_Record && $user->Employee_Record->No == $employeeLeaveApplication->employee->No;
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
        return false;
    }
}
