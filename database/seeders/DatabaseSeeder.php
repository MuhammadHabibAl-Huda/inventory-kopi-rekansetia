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

        // Panggil seeder user
        $this->call(UserSeeder::class);
    }
}
