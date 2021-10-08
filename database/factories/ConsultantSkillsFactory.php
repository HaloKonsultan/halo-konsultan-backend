<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultant;
use App\ConsultantSkill;
use Faker\Generator as Faker;

$factory->define(ConsultantSkill::class, function (Faker $faker) {
    $consultant_id = Consultant::all()->pluck('id')->toArray();

    return [
        //
        'consultant_id' => $faker->randomElement($consultant_id) ,
        'skills' => $faker->randomElement(['communiaction', 'presentation', 'problem solving'])
    ];
});
