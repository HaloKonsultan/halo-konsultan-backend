<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultant;
use App\ConsultantEducation;
use Faker\Generator as Faker;

$factory->define(ConsultantEducation::class, function (Faker $faker) {
    $consultant_id = Consultant::all()->pluck('id')->toArray();

    return [
        //
        'consultant_id' => $faker->randomElement($consultant_id),
        'institution_name' => $faker->company(),
        'major'=> $faker->randomElement(['IT', 'Islam', 'Psikologi']),
        'start_year' => $faker->year(),
        'end_year' => $faker->year()
    ];
});
