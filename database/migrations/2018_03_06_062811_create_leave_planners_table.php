<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('Employee_No',false,true);
            $table->string('Title',100);
            $table->date('Start');
            $table->date('Ends');
            $table->decimal('no_of_days',8,2);
            $table->string('Type',50);
            $table->integer('Application_Code',false,true);
            $table->integer("Current_Year",false,true);
            $table->foreign("Employee_No")->references("employee_id")->on("employees")->onDelete('cascade');
            $table->foreign("Application_Code")->references("Application_Code")->on("employee_leave_applications")->onDelete('cascade');
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
