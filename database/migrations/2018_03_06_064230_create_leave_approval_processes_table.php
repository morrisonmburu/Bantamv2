<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('Application_Code',false,true);
            $table->string('leave_type',20);
            $table->decimal('Approved_days');
            $table->date('Approved_Start_Date');
            $table->date('Approved_End_Date');
            $table->string('Comments','250');
            $table->integer('Approver_id',false,true);
            $table->Integer('Sequence_No');
            $table->boolean("Nav_Synced")->default(false);
            $table->boolean("Web_Synced")->default(true);
            $table->dateTime("Last_Nav_Synced")->nullable();
            $table->dateTime("Last_Web_Synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("Approver_id")->references("Approver_id")->on("employee_approvers")->onDelete('cascade');
            $table->foreign("Application_Code")->references("Application_Code")->on("employee_leave_applications")->onDelete('cascade');
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
