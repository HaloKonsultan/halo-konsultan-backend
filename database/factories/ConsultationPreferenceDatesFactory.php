<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultation;
use App\ConsultationPreferenceDate;
use Faker\Generator as Faker;

$factory->define(ConsultationPreferenceDate::class, function (Faker $faker) {
    $consultation_id = Consultation::all()->pluck('id')->toArray();

    return [
        //
        'consultation_id' => $faker->randomElement($consultation_id), 
        'date' => date('d-m-Y'),
        'time' => date('H:i:s')
    ];
});
