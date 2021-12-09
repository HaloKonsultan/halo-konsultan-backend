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
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782696/Budha_ewsyno.png',
                'name' => 'Konsultan Agama Budha'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782697/Konghucu_g4csda.png',
                'name' => 'Konsultan Agama Konghuchu'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782697/Kristen_o6ljor.png',
                'name' => 'Konsultan Agama Kristen'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782697/Islam_lmlxjh.png',
                'name' => 'Konsultan Agama Islam'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782696/Hindu_g3bxyt.png',
                'name' => 'Konsultan Agama Hindu'
            ],
            [
                'parent_id' => 1,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782697/Katolik_lynis6.png',
                'name' => 'Konsultan Agama Katolik'
            ],
            [
                'parent_id' => 2,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782697/Akuntansi_-_2_iaodua.png',
                'name' => 'Konsultan Akuntansi'
            ],
            [
                'parent_id' => 2,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638796882/Perpajakan_oin4la.png',
                'name' => 'Konsultan Perpajakan'
            ],
            [
                'parent_id' => 2,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638796882/Investasi_-_2_gb6mjx.png',
                'name' => 'Konsultan Investasi Keuangan'
            ],
            [
                'parent_id' => 3,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782698/Listrik_bjdvr4.png',
                'name' => 'Konsultan Listrik'
            ],
            [
                'parent_id' => 3,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782695/Tata-Letak-Interior_-_2_1_ucy0go.png',
                'name' => 'Konsultan Tata Letak Interior'
            ],
            [
                'parent_id' => 3,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782695/Perpipaan_plrqgv.png',
                'name' => 'Konsultan Perpipaan'
            ],
            [
                'parent_id' => 4,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782695/Psikologi_-_2_l5saik.png',
                'name' => 'Konsultan Psikologi'
            ],
            [
                'parent_id' => 4,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782696/Gizi_-_4_ab1xe1.png',
                'name' => 'Konsultan Gizi'
            ],
            [
                'parent_id' => 4,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782696/Umum_agu64a.png',
                'name' => 'Konsultan Kesehatan Umum'
            ],
            [
                'parent_id' => 5,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782697/Legalitas_-_2_ebjmsz.png',
                'name' => 'Konsultan Hukum Legalitas'
            ],
            [
                'parent_id' => 5,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782695/Bisnis_-_2_bfomws.png',
                'name' => 'Konsultan Hukum Bisnis'
            ],
            [
                'parent_id' => 5,
                'logo' => 'https://res.cloudinary.com/dkao45dpc/image/upload/v1638782696/Hukum_1_slocir.png',
                'name' => 'Konsultan Hukum Pidana'
            ],
        ];

        foreach($data as $key => $value) {
            Categories::create($value);
        }
    }
}
