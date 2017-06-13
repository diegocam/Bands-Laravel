<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Album::class, function (Faker\Generator $faker) {

    return [
        'band_id' => $faker->randomElement(App\Band::pluck('id')->toArray()),
        'name' => $faker->sentence(3),
        'recorded_date' => $faker->date(),
        'release_date' => $faker->date(),
        'numberoftracks' => $faker->numberBetween(1,20),
        'label' => $faker->word,
        'producer' => $faker->name,
        'genre' => $faker->word,
    ];
});
