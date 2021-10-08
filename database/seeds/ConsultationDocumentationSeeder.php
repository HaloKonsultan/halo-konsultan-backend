<?php

use App\ConsultationDocument;
use Illuminate\Database\Seeder;

class ConsultationDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultationDocument::class,10)->create();
    }
}
