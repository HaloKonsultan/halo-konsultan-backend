<?php

use App\ParentCategories;
use Illuminate\Database\Seeder;

class ParentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ParentCategories::class,4)->create();
    }
}
