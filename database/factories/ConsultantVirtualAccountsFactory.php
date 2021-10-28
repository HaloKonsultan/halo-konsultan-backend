<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultant;
use App\ConsultantVirtualAccount;
use Faker\Generator as Faker;

$factory->define(ConsultantVirtualAccount::class, function (Faker $faker) {
    $consultant_id = Consultant::all()->pluck('id')->toArray();

    return [
        //
        'consultant_id' => $faker->randomElement($consultant_id), 
        'card_number' => $faker->numerify('#######'), 
        'bank' => $faker->randomElement(['BNI', 'Mandiri', 'BCA', 'BRI']),
        'name' => $faker->name()
    ];
});
