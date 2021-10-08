<?php

use App\ConsultantVirtualAccount;
use Illuminate\Database\Seeder;

class ConsultantVirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ConsultantVirtualAccount::class,10)->create();
    }
}
