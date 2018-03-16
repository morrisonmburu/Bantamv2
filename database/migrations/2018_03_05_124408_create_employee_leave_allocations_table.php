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
            $table->increments('id');
            $table->string('Leave_Period', 50);
            $table->string('Employee_No', 50);
            $table->string('Leave_Code',20);
            $table->string('LTypes_Description',255);
            $table->date('Maturity_Date');
            $table->decimal('Balance_B_F',5,2);
            $table->decimal('Accrued_Days',5,2);
            $table->decimal('Allocated_Days',5,2);
            $table->decimal('Taken',5,2);
            $table->decimal('Balance',5,2);
            $table->string('Comments',250)->nullable();

            $table->boolean("Nav_Sync")->default(false);
            $table->boolean("Web_Sync")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->nullable();
            $table->dateTime("Web_Sync_TimeStamp")->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign("Employee_No")->references("No")->on("employees")->onDelete('cascade');
            $table->unique(['Employee_No', 'Leave_Period', 'Leave_Code'], 'employee_leave_allocations_composite_key');
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
