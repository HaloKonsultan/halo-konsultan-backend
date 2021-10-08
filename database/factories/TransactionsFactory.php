<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultation;
use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $consultation_id = Consultation::all()->pluck('id')->toArray();

    return [
        //
        'consultation_id' => $faker->randomElement($consultation_id), 
        'status' => $faker->randomElement(['waiting', 'completed', 'failed'])
    ];
});
