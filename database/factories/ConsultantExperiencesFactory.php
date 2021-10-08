<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultant;
use App\ConsultantExperience;
use Faker\Generator as Faker;

$factory->define(ConsultantExperience::class, function (Faker $faker) {
    $consultant_id = Consultant::all()->pluck('id')->toArray();
    
    return [
        //
        'consultant_id' => $faker->randomElement($consultant_id),
        'position' => $faker->jobTitle(), 
        'start_year' => $faker->year(), 
        'end_year' => $faker->year()
    ];
});
