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
            $table->integer('employee_no',false,true);
            $table->string('title',100);
            $table->date('start');
            $table->date('ends');
            $table->decimal('no_of_days',8,2);
            $table->string('type',50);
            $table->integer('application_code',false,true);
            $table->integer("current_year",false,true);
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("employee_no")->references("employee_id")->on("employees")->onDelete('cascade');
            $table->foreign("application_code")->references("application_code")->on("employee_leave_applications")->onDelete('cascade');
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
