<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_approvers', function (Blueprint $table) {
            $table->increments('Approver_id');
            $table->integer('Employee_id',false,true);
            $table->integer('Sequence_No',false,true);
            $table->string('Comments',250);
            $table->boolean("Nav_Synced");
            $table->boolean("Web_Synced");
            $table->dateTime("Last_Nav_Synced");
            $table->dateTime("Last_Web_Synced");
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
        Schema::dropIfExists('employee_approvers');
    }
}
