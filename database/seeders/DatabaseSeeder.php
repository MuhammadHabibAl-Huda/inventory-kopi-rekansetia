<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder kopi rekan setia yang sudah kamu buat di sini:
        $this->call(KopiRekanSetiaSeeder::class);

        // Buat akun Admin
        User::create([
            'name' => 'Admin Rekan Setia',
            'email' => 'admin@rekansetia.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Buat akun Barista
        User::create([
            'name' => 'Barista Rekan Setia',
            'email' => 'barista@rekansetia.com',
            'password' => 'password',
            'role' => 'barista',
        ]);
    }
}
