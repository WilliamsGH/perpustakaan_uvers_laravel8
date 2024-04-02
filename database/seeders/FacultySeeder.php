<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faculty::create(['name' => 'Others']);
        Faculty::create(['name' => 'Fakultas Komputer']);
        Faculty::create(['name' => 'Fakultas Bisnis']);
        Faculty::create(['name' => 'Fakultas Teknik']);
        Faculty::create(['name' => 'Fakultas Pendidikan']);
        Faculty::create(['name' => 'Fakultas Seni']);
    }
}
