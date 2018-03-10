<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLeaveApprovalProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_approval_processes', function (Blueprint $table) {
            $table->increments('approval_process_id');
            $table->string('application_code',50);
            $table->string('leave_type',20);
            $table->decimal('approved_days');
            $table->date('approved_start_date');
            $table->date('approved_end_date');
            $table->string('comments','250');
            $table->string('approver_id',50);
            $table->Integer('sequence_no');
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("approver_id")->references("Approver")->on("employee_approvers")->onDelete('cascade');
            $table->foreign("application_code")->references("Application_Code")->on("employee_leave_applications")->onDelete('cascade');
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
        Schema::dropIfExists('leave_approval_processes');
    }
}
