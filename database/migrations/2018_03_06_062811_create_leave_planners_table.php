<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLeavePlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_planners', function (Blueprint $table) {
            $table->increments('leave_planner_id');
            $table->string('employee_no',50);
            $table->string('title',100);
            $table->date('start');
            $table->date('ends');
            $table->decimal('no_of_days',8,2);
            $table->string('type',50);
            $table->string('application_code',50);
            $table->integer("current_year",false,true);
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime("Web_Sync_TimeStamp")->nullable();
            $table->foreign("employee_no")->references("No")->on("employees")->onDelete('cascade');
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
        Schema::dropIfExists('leave_planners');
    }
}
