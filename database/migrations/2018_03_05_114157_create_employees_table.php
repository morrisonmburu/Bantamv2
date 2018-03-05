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
            $table->string('First_name',30);
            $table->string('Middle_name',30);
            $table->string('Last_name',30);
            $table->string('Initials',30);
            $table->string('Job_Title',30);
            $table->string('Address',50);
            $table->string('City',30);
            $table->string('Post_Code',20);
            $table->string('County',30);
            $table->string('Phone_No',30);
            $table->string('Mobile_Phone_No',30);
            $table->string('E_Mail',30);
            $table->date('Birth_date');
            $table->enum('Gender',['male','female']);
            $table->date('Employment_Date');
            $table->string('Employee_No',50)->unique();
            $table->string('Status');
            $table->integer('Department');
            $table->date('Last_Date_Modified');
            $table->date('Date_Filter');
            $table->string('Company_E-Mail',80);
            $table->string('Title',30);
            $table->string('NSSF_No',20);
            $table->string('NHIF_No',20);
            $table->string('PIN_No',20);
            $table->string('National_ID',20);
            $table->string('HELB_NO',20);
            $table->string('Sacco_coop_No',20);
            $table->integer('Designations');
            $table->string('Passport_No',20);
            $table->string('Grade',30);
            $table->integer('Base_Calendar');
            $table->foreign("user_id")->references("id")->on("Users")->onDelete('cascade');;
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
