<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->boolean("Nav_Synced")->default(false);
            $table->boolean("Web_Synced")->default(true);
            $table->dateTime("Last_Nav_Synced")->nullable();
            $table->dateTime("Last_Web_Synced")->default(DB::raw('CURRENT_TIMESTAMP'));;
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
