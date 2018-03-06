<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('Document_type',['leave','appraisal','Approved','training','cash']);
            $table->boolean('Enabled');
            $table->decimal('Due_Days');
            $table->boolean("Nav_Synced");
            $table->boolean("Web_Synced");
            $table->dateTime("Last_Nav_Synced");
            $table->dateTime("Last_Web_Synced");
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
        Schema::dropIfExists('approval_templates');
    }
}
