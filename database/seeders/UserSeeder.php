<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah Admin sudah ada untuk menghindari duplikat
        if (!User::where('email', 'admin@rekansetia.com')->exists()) {
            User::create([
                'name' => 'Admin Rekan Setia',
                'email' => 'admin@rekansetia.com',
                'password' => Hash::make('password'), // Pastikan di-hash agar bisa login
                'role' => 'admin',
            ]);
        }

        // Cek apakah Barista sudah ada
        if (!User::where('email', 'barista@rekansetia.com')->exists()) {
            User::create([
                'name' => 'Barista Rekan Setia',
                'email' => 'barista@rekansetia.com',
                'password' => Hash::make('password'),
                'role' => 'barista',
            ]);
        }
    }
}
