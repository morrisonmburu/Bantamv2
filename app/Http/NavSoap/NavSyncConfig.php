<?php
return (object)array(
    'NAV_USER' => env("NAV_USER"),
    'NAV_PWD' => env("NAV_PWD"),
    'NAV_BASE_URL' => 'http://172.16.200.67:9347/NAVDEMO/WS/CRONUS%20International%20Ltd.',
    'NAV_SOAP_EMPLOYEE' => 'Page/Employees',
    'NAV_SOAP_LEAVE_ALLOC' => 'Page/LeaveAlloc',
    'NAV_SOAP_LEAVE_APPS' => 'Page/LeaveApps',
    'NAV_SOAP_LEAVE_MANAGER' => 'Codeunit/LeaveManager',
    'NAV_SOAP_LEAVE_PERIODS' => 'Page/LeavePeriods',
    'NAV_SOAP_LEAVE_TYPES' => 'Page/LeaveTypes',
    'NAV_SOAP_PROFILE_PIC' => 'Codeunit/ProfilePics',
    'NAV_SOAP_APPROVERS' => 'Page/Approvers',
    'NAV_HR_APPROVALS' => 'Page/HRApprovals',
    'NAV_SOAP_LEAVE_MANAGER_CODES' => [
        2 => "Invalid Calendar",
        3 => "Invalid Leave Type",
        4 => "Invalid Start Date",
        5 => "Zero No. of Days",
        6 => "Invalid Employee",
        7 => "Date Before Today",
        8 => "Employee does not Exist",
        9 => "Employe Not Active",
        10 => "Leave Type Deactivated",
        11 => "Non Working Start Date",
    ]
);