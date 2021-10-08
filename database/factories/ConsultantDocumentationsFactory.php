<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultant;
use App\ConsultantDocumentation;
use Faker\Generator as Faker;

$factory->define(ConsultantDocumentation::class, function (Faker $faker) {
    $consultant_id = Consultant::all()->pluck('id')->toArray();
    return [
        //
        'consultant_id' => $faker->randomElement($consultant_id),
        'photo' => $faker->imageUrl()
    ];
});
