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
$factory->define(App\Band::class, function (Faker\Generator $faker) {

    $bandName = sprintf('The %ss', $faker->word);

    return [
        'name' => $bandName,
        'start_date' => $faker->dateTimeBetween($startDate = '-20 years', $endDate = 'now'),
        'website' => $faker->url,
        'still_active' => $faker->boolean(),
    ];
});
