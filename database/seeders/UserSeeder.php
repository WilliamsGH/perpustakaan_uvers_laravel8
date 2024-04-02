<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'institution_id' => 1,
            'major_id' => 1,
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'super_admin'
        ]);

        User::create([
            'institution_id' => 1,
            'major_id' => 1,
            'name' => 'Williams',
            'email' => 'williams342002@uvers.ac.id',
            'username' => '2020133002',
            'password' => Hash::make('admin'),
            'role' => 'super_admin'
        ]);
    }
}
