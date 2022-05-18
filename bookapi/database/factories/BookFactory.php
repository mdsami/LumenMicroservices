<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
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

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3, true),
        'description' => $faker->sentence(6, true),
        'price' => $faker->numberBetween(5, 50),
        'author_id' => $faker->numberBetween(1, 50),
    ];
});
