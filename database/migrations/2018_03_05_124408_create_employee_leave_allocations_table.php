<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('Entry_no');
            $table->integer('Employee_no',false,true);
            $table->string('leave_code',20);
            $table->date('Maturity_Date');
            $table->decimal('Balance');
            $table->decimal('Accrued_Days');
            $table->string('Comments',250);
            $table->decimal('Days_Taken');
            $table->decimal('Days_Applied');
            $table->decimal('Days_Approved');
            $table->integer('Days_Approved_Taken');
            $table->decimal('Allocated_Days');
            $table->string('Leave Period');
            $table->foreign("Employee_no")->references("employee_id")->on("Employees")->onDelete('cascade');
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
