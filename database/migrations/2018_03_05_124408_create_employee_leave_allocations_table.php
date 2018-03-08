<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEmployeeLeaveAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_allocations', function (Blueprint $table) {
            $table->increments('entry_no');
            $table->string('employee_no', 50);
            $table->string('leave_code',20);
            $table->date('maturity_date');
            $table->decimal('balance');
            $table->decimal('accrued_days');
            $table->string('comments',250);
            $table->decimal('days_taken');
            $table->decimal('days_applied');
            $table->decimal('days_approved');
            $table->integer('days_approved_taken');
            $table->decimal('allocated_days');
            $table->integer('leave_period',false,true);
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("employee_no")->references("No")->on("employees")->onDelete('cascade');
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
        Schema::dropIfExists('employee_leave_allocations');
    }
}
