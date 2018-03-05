<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_applications', function (Blueprint $table) {
            $table->increments('Application_Code');
            $table->integer('Employee_no',false,true);
            $table->integer('leave_code',false,true);
            $table->decimal('Days_applied');
            $table->date('Start_date');
            $table->date('End_date');
            $table->date('Application_Date');
            $table->decimal('Approved_days');
            $table->date('Approved_Start_Date');
            $table->date('Reporting_Date');
            $table->boolean('Verified_by_manager');
            $table->date('Verification_Date');
            $table->enum('Status',['New','Being_Processed','Approved','Rejected','Canceled']);
            $table->date('Approved_end_date');
            $table->date('Approval_date');
            $table->string('Comments','250');
            $table->boolean('Taken');
            $table->string('Leave_period');
            $table->foreign("Employee_no")->references("employee_id")->on("Employees")->onDelete('cascade');
            $table->foreign("leave_code")->references("Leave_type_id")->on("leave_types")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_leave_applications');
    }
}
