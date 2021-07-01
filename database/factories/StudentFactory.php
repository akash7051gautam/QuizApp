<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Student;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(App\Student::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'user_id' => 1,
        'rollno' => 111111111111,
        'email' => $faker->email,
        'password' => 'password',
        'status' => 0,
    ];
});
