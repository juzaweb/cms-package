<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Juzaweb\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make('12345678'),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
        'is_admin' => 0
    ];
});
