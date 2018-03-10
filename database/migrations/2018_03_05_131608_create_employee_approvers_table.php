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
            $table->increments('id');
            $table->string('Employee',50);
            $table->integer('Approval_Level');
            $table->string('Approver',50)->unique();
            $table->string("NamesApprvr");
            $table->string("Comments", 50)->nullable();
            $table->foreign('Employee')->references('No')->on('employees');
            $table->unique(['Employee', 'Approver']);

            $table->boolean("Nav_Sync")->default(false);
            $table->boolean("Web_Sync")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->nullable();
            $table->dateTime("Web_Sync_TimeStamp")->default(DB::raw('CURRENT_TIMESTAMP'));

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
