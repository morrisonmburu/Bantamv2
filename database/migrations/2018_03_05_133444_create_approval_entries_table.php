<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->integer('approval_template',false,true);
            $table->integer('approver_id',false,true);
            $table->integer('document_no',false,true);
            $table->integer('sequence_no');
            $table->integer('employee_no',false,true);
            $table->enum('status',['created','open','cancelled','approved','rejected']);
            $table->datetime('date_sent_for_approval');
            $table->datetime('last_date_time_modified');
            $table->string('last_modified_by_id');
            $table->string('comment');
            $table->date('due_date');
            $table->integer("current_year",false,true);
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->foreign("approval_template")->references("id")->on("approval_templates")->onDelete('cascade');
            $table->foreign("approver_id")->references("approver_id")->on("employee_approvers")->onDelete('cascade');
            $table->foreign("employee_no")->references("employee_id")->on("employees")->onDelete('cascade');
            $table->foreign("document_no")->references("application_Code")->on("employee_leave_applications")->onDelete('cascade');
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
