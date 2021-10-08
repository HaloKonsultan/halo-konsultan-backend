<?php

use App\ConsultantDocumentation;
use Illuminate\Database\Seeder;

class ConsultantDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultantDocumentation::class,10)->create();
    }
}
