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
        $data = [
            [
                'name' => 'Konsultan Agama'
            ],
            [
                'name' => 'Konsultan Keuangan'
            ],
            [
                'name' => 'Konsultan Bangunan'
            ],
            [
                'name' => 'Konsultan Kesehatan'
            ],
        ];

        foreach($data as $key => $value) {
            ParentCategories::create($value);
        }
    }
}
