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
            $table->integer('Table_ID',false,true)->unique();
            $table->string('Document_Type');
            $table->string('Document_No',50);
            $table->integer('Sequence_No');
            $table->string('Status',50);
            $table->string('Approval_Details',255)->nullable();
            $table->string('Sender_ID',50)->unique();
            $table->string('Approver_ID', 50);
            $table->string('Document_Owner', 50);
            $table->dateTime('Date_Time_Sent_for_Approval');
            $table->date('Last_Date_Time_Modified')->nullable();
            $table->string("Last_Modified_By_ID",50)->nullable();
            $table->string("Comment",50);
            $table->date("Due_Date");

            $table->boolean("Nav_Sync")->default(false);
            $table->boolean("Web_Sync")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->nullable();
            $table->dateTime("Web_Sync_TimeStamp")->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign("Approver_ID")->references("Approver")->on("employee_approvers")->onDelete('cascade');
            $table->foreign("Sender_ID")->references("No")->on("employees")->onDelete('cascade');
            $table->foreign("Document_No")->references("Application_Code")->on("employee_leave_applications")->onDelete('cascade');
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
