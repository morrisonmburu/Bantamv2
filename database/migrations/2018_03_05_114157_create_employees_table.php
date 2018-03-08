<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('employee_id');
            $table->string('No',50)->unique();
            $table->integer('user_id',false,true)->nullable();
            $table->string('first_name',30)->nullable();
            $table->string('middle_name',30)->nullable();
            $table->string('last_name',30)->nullable();
            $table->string('initials',30)->nullable();
            $table->string('job_title',30)->nullable();
            $table->string('address',50)->nullable();
            $table->string('city',30)->nullable();
            $table->string('post_code',20)->nullable();
            $table->string('county',30)->nullable();
            $table->string('phone_no',30)->nullable();
            $table->string('mobile_phone_no',30)->nullable();
            $table->string('e_mail',100)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender',['Male','Female'])->nullable();
            $table->date('employment_date')->nullable();
            $table->string('status')->nullable();
            $table->integer('department')->nullable();
            $table->date('last_date_modified')->nullable();
            $table->date('date_filter')->nullable();
            $table->string('company_e-mail',80)->nullable();
            $table->string('title',30)->nullable();
            $table->string('NSSF_No',20)->nullable();
            $table->string('NHIF_No',20)->nullable();
            $table->string('PIN_No',20)->nullable();
            $table->string('national_id',20)->nullable();
            $table->string('HELB_NO',20)->nullable();
            $table->string('sacco_coop_no',20)->nullable();
            $table->integer('designations')->nullable();
            $table->string('passport_no',20)->nullable();
            $table->string('grade',30)->nullable();
            $table->string('profile_picture',100)->nullable();
            $table->string('base_calendar', 30)->nullable();
            $table->boolean("nav_synced")->default(false);
            $table->boolean("web_synced")->default(true);
            $table->dateTime("last_nav_synced")->nullable();
            $table->dateTime("last_web_synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
}
