<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quiz;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => 2,
        'status' => $faker->randomElement(['Open', 'In Design']),
    ];
});
