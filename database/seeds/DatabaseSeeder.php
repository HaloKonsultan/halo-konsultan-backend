<?php

use App\ConsultantEducation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ParentCategoriesSeeder::class,
            CategoriesSeeder::class,
            ConsultantSeeder::class,
            UserSeeder::class,
            ConsultationsSeeder::class,
            ConsultantDocumentationSeeder::class,
            ConsultantEducationSeeder::class,
            ConsultantExperienceSeeder::class,
            ConsultantSkillSeeder::class,
            ConsultantVirtualAccountSeeder::class,
            ConsultantDocumentationSeeder::class,
            ConsultationPreferenceDateSeeder::class,
            TransactionSeeder::class,
            UserBankDocumentSeeder::class
        ]);

    }
}
