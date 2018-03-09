<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Code',20)->unique();
            $table->string('Description',20);
            $table->decimal('Days',5,2);
            $table->boolean('InActive');
            $table->boolean('Accrue_Days');
            $table->boolean('Unlimited_Days');
            $table->enum('Gender',['Male','Female','both']);
            $table->decimal('Balance',5,2);
            $table->boolean('Inclusive_of_Holidays');
            $table->decimal('Max_Carry_Forward_Days',5,2);
            $table->boolean('Off_Holidays_Days_Leave');
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
        Schema::dropIfExists('leave_types');
    }
}
