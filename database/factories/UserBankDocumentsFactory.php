<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\UserBankDocument;
use Faker\Generator as Faker;

$factory->define(UserBankDocument::class, function (Faker $faker) {
    $user_id = User::all()->pluck('id')->toArray();

    return [
        //
        'user_id' => $faker->randomElement($user_id),
        'filename' => $faker->fileExtension(), 
        'url' => $faker->fileExtension()
    ];
});
