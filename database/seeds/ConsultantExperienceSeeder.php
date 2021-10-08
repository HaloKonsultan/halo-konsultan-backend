<?php

use App\ConsultantExperience;
use Illuminate\Database\Seeder;

class ConsultantExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultantExperience::class,10)->create();
    }
}
