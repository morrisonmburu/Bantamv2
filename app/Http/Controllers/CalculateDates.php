<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeLeaveApplication;
use App\Http\NavSoap\NavSyncManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Application;

trait CalculateDates{
    private function calculateEmployeeLeaveDates($validatedData, Employee $employee = null,
                                                 EmployeeLeaveApplication $application = null)
    {
        $employee = $employee? $employee : Auth::user()->Employee_Record;

        $this->checkDatesOverlap($validatedData['start_date'], $validatedData['end_date'], $employee, $application);
        $manager = new NavSyncManager();

        try {
            $result = $manager->calculateLeaveDates(
                $validatedData['leave_code'],
                $employee->No,
                $employee->_x003C_Base_Calendar_cODE_x003E_,
                $validatedData['start_date'],
                $validatedData['end_date']
            );
        } catch (\Exception $e) {
            if ($e->getCode() == NavSyncManager::$NAV_HTTP_ERROR_CODE)
                abort(400, $e->getMessage());
            else {
                throw $e;
            }
        }

        return $result;

    }

    private function checkDatesOverlap($start_date, $end_date, Employee $employee = null, EmployeeLeaveApplication $application = null){
        $employee = $employee? $employee : Auth::user()->Employee_Record;
        $res = EmployeeLeaveApplication::where('Status', '!=' , 'Canceled')
            ->where('Employee_No', $employee->No)
            ->where(function ($query) use($start_date, $end_date){
                $query->where(function ($q) use($start_date) {
                    $q->where('Start_Date', '<=', $start_date);
                    $q->where('End_Date', '>=', $start_date);
                })->orWhere(function ($q) use($end_date) {
                    $q->where('Start_Date', '<=', $end_date);
                    $q->where('End_Date', '>=', $end_date);
                })->orWhere(function ($q) use($start_date, $end_date) {
                    $q->where('Start_Date', '<=', $start_date);
                    $q->where('End_Date', '>=', $end_date);
                })->orWhere(function ($q) use($start_date, $end_date) {
                    $q->where('Start_Date', '>=', $start_date);
                    $q->where('End_Date', '<=', $end_date);
                });
            });

        if($application){
            $res->where('Application_Code', '!=', $application->Application_Code);
        }
        $res = $res->get();
        if($res->count())
        {
            abort(400, "Leave application overlaps with another.");
        }
    }
}