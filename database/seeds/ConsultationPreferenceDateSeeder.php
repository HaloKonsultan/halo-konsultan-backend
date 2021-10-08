<?php

use App\ConsultationPreferenceDate;
use Illuminate\Database\Seeder;

class ConsultationPreferenceDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultationPreferenceDate::class,10)->create();
    }
}
