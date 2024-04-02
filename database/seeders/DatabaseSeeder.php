<?php

namespace Database\Seeders;

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
        // Master Data
        $this->call(InstitutionSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(CategorySeeder::class);

        // Additional Data
        $this->call(UserSeeder::class);
    }
}
