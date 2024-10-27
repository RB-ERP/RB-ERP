<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('admin1234'),
                'remember_token' => Str::random(10),
                'role' => 'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User One',
                'email' => 'bayufadayan@gmail.com',
                'username' => 'bayufadayan',
                'email_verified_at' => now(),
                'password' => Hash::make('bayubayu'), 
                'remember_token' => Str::random(10),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ini Admin',
                'email' => 'admin@example.com',
                'username' => 'inimahadmin',
                'email_verified_at' => now(),
                'password' => Hash::make('inimahadmin'), 
                'remember_token' => Str::random(10),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
