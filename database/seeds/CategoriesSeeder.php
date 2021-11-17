<?php

use App\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
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
                'parent_id' => 2,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385082/ueqm3fnniscekrvelmpu.png',
                'name' => 'Konsultan Akuntansi'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634384952/bhjtaws3lubwejshjksq.png',
                'name' => 'Konsultan Agama Budha'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385013/duxsu5fu1xdb59kgd3gz.png',
                'name' => 'Konsultan Agama Konghuchu'
            ],
            [
                'parent_id' => 3,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385055/fmjjhch7iejbzwlrl2uc.png',
                'name' => 'Konsultan Tata Letak Interior'
            ],
            [
                'parent_id' => 2,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385129/cozsdsuyz4ecslekgqdi.png',
                'name' => 'Konsultan Investasi Keuangan'
            ],
            [
                'parent_id' => 2,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385161/ygbklzmhgzrrgcgrigno.png',
                'name' => 'Konsultan Kesehatan Umum'
            ],
            [
                'parent_id' => 4,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634384990/ddfrniia4zouogrb9gmt.png',
                'name' => 'Konsultan Gizi'
            ],
            [
                'parent_id' => 4,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385185/zb0fjsaybgtujjknydsm.png',
                'name' => 'Konsultan Psikologi'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/anongtf/image/upload/v1634385248/ucj1afau9ug0rf9yfwok.png',
                'name' => 'Konsultan Agama Islam'
            ],
        ];

        foreach($data as $key => $value) {
            Categories::create($value);
        }
    }
}
