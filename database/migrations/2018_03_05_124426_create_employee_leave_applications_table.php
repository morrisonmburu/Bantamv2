<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->boolean('Verified_by_manager')->nullable();
            $table->date('Verification_Date');
            $table->enum('Status',['New','Being_Processed','Approved','Rejected','Canceled']);
            $table->date('Approved_end_date');
            $table->date('Approval_date');
            $table->string('Comments','250')->nullable();
            $table->boolean('Taken');
            $table->integer('Leave_Period',false,true);
            $table->boolean("Nav_Synced")->default(false);
            $table->boolean("Web_Synced")->default(true);
            $table->dateTime("Last_Nav_Synced")->nullable();
            $table->dateTime("Last_Web_Synced")->default(DB::raw('CURRENT_TIMESTAMP'));
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
