<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consultation;
use App\ConsultationDocument;
use Faker\Generator as Faker;

$factory->define(ConsultationDocument::class, function (Faker $faker) {
    $consultation_id = Consultation::all()->pluck('id')->toArray();

return [
        //
        'consultation_id' => $faker->randomElement($consultation_id),
        'name' => $faker->fileExtension(),
        'description' => $faker->sentence(), 
        'file' => $faker->fileExtension()
    ];
});
