<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('user_id',false,true);
            $table->string('First_name',30)->nullable();
            $table->string('Middle_name',30)->nullable();
            $table->string('Last_name',30)->nullable();
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
            $table->enum('Gender',['male','female'])->nullable();
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
            $table->integer('Base_Calendar')->nullable();
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
