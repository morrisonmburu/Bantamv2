<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->enum('document_type',['leave','appraisal','Approved','training','cash']);
            $table->boolean('enabled');
            $table->decimal('due_days');
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime("Web_Sync_TimeStamp")->nullable();
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
