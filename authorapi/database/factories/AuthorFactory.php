<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Author::class, function (Faker $faker) {

    $gender = $faker->randomElement(['male', 'female']);

    return [
        'name' => $faker->name($gender),
        'gender' => $gender,
        'country' => $faker->country,
    ];
});
