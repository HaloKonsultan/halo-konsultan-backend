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
        'status_invoice' => $faker->randomElement(['PAID', 'PENDING', 'EXPIRED']),
        'status_disbursment'  => $faker->randomElement(['PENDING', 'EXPIRED', 'COMPLETED']), 
        'amount' => $faker->numberBetween(10000,200000), 
        'invoice_url' => $faker->url(), 
        'expiry_date' => $faker->date(),
        'bank_code' => $faker->randomElement(), 
        'account_holder_name' => $faker->name(), 
        'account_number' => $faker->numerify('###########')
    ];
});
