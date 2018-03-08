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
            $table->increments('approver_id');
            $table->integer('employee_id',false,true);
            $table->integer('sequence_No',false,true);
            $table->string('comments',250);
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));;
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
