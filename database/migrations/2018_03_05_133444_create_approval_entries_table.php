<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('approval_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Approval_template',false,true);
            $table->integer('Approver_id',false,true);
            $table->integer('Document_no',false,true);
            $table->integer('Sequence_no');
            $table->integer('Employee_no',false,true);
            $table->enum('status',['created','open','cancelled','approved','rejected']);
            $table->datetime('Date_sent_for_approval');
            $table->datetime('last_date_time_modified');
            $table->string('last_modified_by_id');
            $table->string('Comment');
            $table->date('Due_Date');
            $table->integer("Current_Year",false,true);
            $table->boolean("Nav_Synced")->default(false);
            $table->boolean("Web_Synced")->default(true);
            $table->dateTime("Last_Nav_Synced")->nullable();
            $table->dateTime("Last_Web_Synced")->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->foreign("Approval_template")->references("id")->on("approval_templates")->onDelete('cascade');
            $table->foreign("Approver_id")->references("Approver_id")->on("employee_approvers")->onDelete('cascade');
            $table->foreign("Employee_no")->references("employee_id")->on("employees")->onDelete('cascade');
            $table->foreign("Document_no")->references("Application_Code")->on("employee_leave_applications")->onDelete('cascade');
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
        Schema::dropIfExists('approval_entries');
    }
}
