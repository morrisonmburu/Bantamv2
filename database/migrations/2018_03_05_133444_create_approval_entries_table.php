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
            $table->string('Table_ID', 50)->unique();
            $table->enum('Document_Type', ['Leave', 'Training', 'Appraisal', 'Succession', 'Payroll', 'Recruitment']);
            $table->string('Document_No',50);
            $table->integer('Sequence_No');
            $table->enum('Status',['Created', 'Open', 'Canceled', 'Rejected', 'Approved']);
            $table->string('Approval_Details',255)->nullable();
            $table->string('Sender_ID',50);
            $table->string('Approver_ID', 50);
            $table->string('Document_Owner', 50)->nullable();
            $table->dateTime('Date_Time_Sent_for_Approval')->nullable();
            $table->date('Last_Date_Time_Modified')->nullable();
            $table->string("Last_Modified_By_ID",50)->nullable();
            $table->string("Comment",50)->nullable();
            $table->date("Due_Date")->nullable();
            $table->boolean("Nav_Sync")->default(false);
            $table->boolean("Web_Sync")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime("Web_Sync_TimeStamp")->nullable();
            $table->foreign("Approver_ID")->references("no")->on("employees")->onDelete('cascade');
            $table->foreign("Sender_ID")->references("No")->on("employees")->onDelete('cascade');
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
