<?php

use Illuminate\Database\Seeder;

class ApprovalEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = \App\Employee::where('No', 'AH')->first();
    }
}
