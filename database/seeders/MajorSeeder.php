<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Major::create(['name' => 'Other', 'faculty_id' => 1, 'alias' => '']);
        Major::create(['name' => 'Pendidikan Bahasa Mandarin', 'faculty_id' => 5, 'alias' => 'PBM']);
        Major::create(['name' => 'Akuntansi', 'faculty_id' => 3, 'alias' => 'AK']);
        Major::create(['name' => 'Manajemen', 'faculty_id' => 3, 'alias' => 'MNG']);
        Major::create(['name' => 'Seni Musik', 'faculty_id' => 6, 'alias' => 'SM']);
        Major::create(['name' => 'Seni Tari', 'faculty_id' => 6, 'alias' => 'ST']);
        Major::create(['name' => 'Teknik Industri', 'faculty_id' => 4, 'alias' => 'TI']);
        Major::create(['name' => 'Teknik Lingkungan', 'faculty_id' => 4, 'alias' => 'TL']);
        Major::create(['name' => 'Sistem Informasi', 'faculty_id' => 2, 'alias' => 'SI']);
        Major::create(['name' => 'Teknik Informatika', 'faculty_id' => 2, 'alias' => 'TI']);
        Major::create(['name' => 'Teknik Perangkat Lunak', 'faculty_id' => 2, 'alias' => 'TPL']);
    }
}
