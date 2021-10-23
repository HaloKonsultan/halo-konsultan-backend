<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultant;
use App\Consultation;
use App\User;
use Faker\Generator as Faker;

$factory->define(Consultation::class, function (Faker $faker) {
    $consultant_id = Consultant::all()->pluck('id')->toArray();
    $user_id = User::all()->pluck('id')->toArray();

    return [
        //
        'description' => $faker->paragraph(),
        'consultant_id' => $faker->randomElement($consultant_id) ,
        'user_id' => $faker->randomElement($user_id), 
        'title' => $faker->sentence(), 
        'consultation_price' => $faker->randomDigit(),
        'location' => $faker->city(), 
        'status' => $faker->randomElement(['active', 'waiting', 'done']),
        'is_confirmed' => $faker->boolean(), 
        'preference' => $faker->randomElement(['online', 'offline']), 
        'date' => date('d-m-Y'),
        'time' => date('H:i:s'),
        'conference_link' => $faker->url()
    ];
});
