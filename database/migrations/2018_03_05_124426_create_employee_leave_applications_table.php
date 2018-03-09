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
            $table->increments('application_code');
            $table->string('employee_no',50);
            $table->integer('leave_code',false,true);
            $table->decimal('days_applied');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('application_date');
            $table->decimal('approved_days');
            $table->date('approved_start_date');
            $table->date('reporting_date');
            $table->boolean('verified_by_manager')->nullable();
            $table->date('verification_date');
            $table->enum('status',['New','Being_Processed','Approved','Rejected','Canceled']);
            $table->date('approved_end_date');
            $table->date('approval_date');
            $table->string('comments','250')->nullable();
            $table->boolean('taken');
            $table->integer('leave_period',false,true);
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("employee_no")->references("No")->on("employees")->onDelete('cascade');
            $table->foreign("leave_code")->references("leave_type_id")->on("leave_types")->onDelete('cascade');
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
