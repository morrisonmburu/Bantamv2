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
            $table->increments('id');
            $table->string('No',50)->unique();
            $table->integer('user_id',false,true)->nullable();
            $table->string('First_Name',30)->nullable();
            $table->string('Last_Name',30)->nullable();
            $table->string('Middle_Name',30)->nullable();
            $table->string('Initials',30)->nullable();
            $table->string('Job_ID',50)->nullable();
            $table->string('Address',150)->nullable();
            $table->string('Address_2',150)->nullable();
            $table->string('Alt_Address_Code',150)->nullable();
            $table->date('Alt_Address_Start_Date')->nullable();
            $table->date('Alt_Address_End_Date')->nullable();
            $table->date('Contract_Start_Date')->nullable();
            $table->date('Contract_End_Date')->nullable();
            $table->date('End_Of_Probation_Date')->nullable();
            $table->date('Termination_Date')->nullable();
            $table->date('Inactive_Date')->nullable();
            $table->string('City',30)->nullable();
            $table->string('Cause_of_Inactivity_Code',250)->nullable();
            $table->string('Grounds_for_Term_Code',250)->nullable();
            $table->string('Emplymt_Contract_Code',250)->nullable();
            $table->string('Statistics_Group_Code',250)->nullable();
            $table->string('Resource_No',100)->nullable();
            $table->string('Notice_Period',30)->nullable();
            $table->string('Salespers_Purch_Code',250)->nullable();
            $table->string('Post_Code',20)->nullable();
            $table->string('County_Region_Code',30)->nullable();
            $table->string('Phone_No',30)->nullable();
            $table->string('Extension',50)->nullable();
            $table->string('Mobile_Phone_No',30)->nullable();
            $table->string('Pager',50)->nullable();
            $table->string('E_Mail',100)->nullable();
            $table->date('Birth_Date')->nullable();
            $table->enum('Gender',['Male','Female'])->nullable();
            $table->date('Employment_Date')->nullable();
            $table->string('Status',30)->nullable();
            $table->string('Global_Dimension_1_Code',50)->nullable();
            $table->string('Global_Dimension_2_Code',50)->nullable();
            $table->string('Department',100)->nullable();
            $table->string('Profile_Picture',200)->nullable();
            $table->date('Last_Date_Modified')->nullable();
            $table->date('Date_Filter')->nullable();
            $table->string('Company_E_Mail',80)->nullable();
            $table->string('Title',30)->nullable();
            $table->string('NSSF_No',20)->nullable();
            $table->string('NHIF_No',20)->nullable();
            $table->string('PIN_No',20)->nullable();
            $table->string('National_ID',20)->nullable();
            $table->string('Social_Security_No',20)->nullable();
            $table->string('HELB_NO',20)->nullable();
            $table->string('Pay_Mode',20)->nullable();
            $table->string('Passport_No',20)->nullable();
            $table->string('Currency',30)->nullable();
            $table->string('Payroll_Posting_Group',30)->nullable();
            $table->string('Grade',30)->nullable();
            $table->string('Step',30)->nullable();
            $table->string('Payroll_Category',100)->nullable();
            $table->string('Pensionable',30)->nullable();
            $table->string('_x003C_Base_Calendar_cODE_x003E_', 250)->nullable();

            $table->boolean("NSSF_By_Company")->default(false);
            $table->boolean("NHIF_By_Company")->default(false);
            $table->boolean("Disability_PAYE_Exemeption")->default(false);
            $table->boolean("Hold_Payment")->default(false);
            $table->boolean("Use_Daily_Rate")->default(false);

            $table->boolean("Nav_Sync")->default(false);
            $table->boolean("Web_Sync")->default(true);
            $table->dateTime("Nav_Sync_TimeStamp")->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime("Web_Sync_TimeStamp")->nullable();
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
