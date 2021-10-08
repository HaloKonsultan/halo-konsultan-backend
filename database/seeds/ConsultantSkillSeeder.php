<?php

use App\ConsultantSkill;
use Illuminate\Database\Seeder;

class ConsultantSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultantSkill::class,10)->create();
    }
}
