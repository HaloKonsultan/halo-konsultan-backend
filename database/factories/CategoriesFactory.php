<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use App\ParentCategories;
use Faker\Generator as Faker;

$factory->define(Categories::class, function (Faker $faker) {
    $parent_id = ParentCategories::all()->pluck('id')->toArray();

    return [
        //
        'name' => $faker->jobTitle(),
        'logo' => $faker->imageUrl(),
        'parent_id' => $faker->randomElement($parent_id)
    ];
});
