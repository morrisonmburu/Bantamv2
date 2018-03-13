<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'No' => $faker->uuid,
        'First_Name' => $faker->name,
        'Last_Name' => $faker->name,
        'Middle_Name' => $faker->name,
        'E_Mail' => $faker->email
    ];
});
