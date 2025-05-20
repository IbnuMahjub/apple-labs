<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\tm_category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'daus',
            'username' => 'daus',
            'email' => 'daus@gmail.com',
            'password' => bcrypt('12345'),
            'jabatan' => 'Manager',
            'is_admin' => 1

        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        tm_category::create([
            'name' => 'Artikel',
            'slug' => 'artikel',
            'description' => 'Artikel'
        ]);

        tm_category::create([
            'name' => 'Pengumuman',
            'slug' => 'pengumuman',
            'description' => 'Pengumuman'
        ]);
    }
}
