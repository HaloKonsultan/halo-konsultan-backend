<?php

use App\ConsultantEducation;
use Illuminate\Database\Seeder;

class ConsultantEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultantEducation::class,10)->create();
    }
}
