<?php

use App\UserBankDocument;
use Illuminate\Database\Seeder;

class UserBankDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(UserBankDocument::class,10)->create();
    }
}
