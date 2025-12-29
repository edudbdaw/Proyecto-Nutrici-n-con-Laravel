<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(table: 'users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.es',
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);
    }
}