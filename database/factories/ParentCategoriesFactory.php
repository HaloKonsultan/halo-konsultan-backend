<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ParentCategories;
use Faker\Generator as Faker;

$factory->define(ParentCategories::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->randomElement(['agama', 'hukum', 'bangunan', 'kesehatan'])
    ];
});
