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
            $table->string('First_Name',30)->nullable();
            $table->string('Middle_Name',30)->nullable();
            $table->string('Last_Name',30)->nullable();
            $table->string('Initials',30)->nullable();
            $table->string('Job_Title',30)->nullable();
            $table->string('Address',50)->nullable();
            $table->string('City',30)->nullable();
            $table->string('Post_Code',20)->nullable();
            $table->string('County',30)->nullable();
            $table->string('Phone_No',30)->nullable();
            $table->string('Mobile_Phone_No',30)->nullable();
            $table->string('E_Mail',100)->nullable();
            $table->date('Birth_date')->nullable();
            $table->enum('Gender',['Male','Female'])->nullable();
            $table->date('Employment_Date')->nullable();
            $table->string('Status')->nullable();
            $table->integer('Department')->nullable();
            $table->date('Last_Date_Modified')->nullable();
            $table->date('Date_Filter')->nullable();
            $table->string('Company_E-Mail',80)->nullable();
            $table->string('Title',30)->nullable();
            $table->string('NSSF_No',20)->nullable();
            $table->string('NHIF_No',20)->nullable();
            $table->string('PIN_No',20)->nullable();
            $table->string('National_ID',20)->nullable();
            $table->string('HELB_NO',20)->nullable();
            $table->string('Sacco_coop_No',20)->nullable();
            $table->integer('Designations')->nullable();
            $table->string('Passport_No',20)->nullable();
            $table->string('Grade',30)->nullable();
            $table->string('Profile_Picture',100)->nullable();
            $table->string('Base_Calendar', 30)->nullable();
            $table->boolean("Nav_Synced")->default(false);
            $table->boolean("Web_Synced")->default(true);
            $table->dateTime("Last_Nav_Synced")->nullable();
            $table->dateTime("Last_Web_Synced")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("user_id")->references("id")->on("Users")->onDelete('cascade');
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
