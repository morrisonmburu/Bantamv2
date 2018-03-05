<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('Leave_type_id');
            $table->string('Description',20);
            $table->decimal('Days_per_year',5,3);
            $table->boolean('Accrued_Days');
            $table->boolean('Unlimited_Days');
            $table->enum('Gender',['male','female','both']);
            $table->boolean('Inclusive_of_non_working');
            $table->boolean('allow_inactive');
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
