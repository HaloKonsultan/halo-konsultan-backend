<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use App\Consultant;
use Faker\Generator as Faker;

$factory->define(Consultant::class, function (Faker $faker) {
    $category_id = Categories::all()->pluck('id')->toArray();

    return [
        //
        'name' => $faker->name(), 
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
        'gender' => $faker->randomElement(['pria', 'wanita']), 
        'category_id' => $faker->randomElement($category_id),
        'province' => $faker->city(),
        'city' => $faker->city(),
        'photo' => $faker->imageUrl(),
        'likes_total' => $faker->randomNumber(1,100),
        'description'=> $faker->sentence(), 
        'chat_price' => $faker->randomDigit(), 
        'consultation_price' => $faker->randomDigit(), 
        'firebase_id'=> $faker->numberBetween(1,100)
    ];
});
