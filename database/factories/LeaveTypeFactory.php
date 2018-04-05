<?php

use Faker\Generator as Faker;

$factory->define(\App\LeaveType::class, function (Faker $faker) {
    return [
        'Code' =>uniqid(),
        'Description' => $faker->text(10),
        'Days' => 10,
        'InActive' =>false,
        'Accrue_Days' => true,
        'Allow_Application' => true,
        'Unlimited_Days' => true,
        'Gender' => 'Male',
        'Balance' => $faker->name,
        'Inclusive_of_Holidays' => true,
        'Max_Carry_Forward_Days' => $faker->numberBetween(1, 10),
        'Off_Holidays_Days_Leave' => true,
    ];
});
