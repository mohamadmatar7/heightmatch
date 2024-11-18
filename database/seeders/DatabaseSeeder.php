<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Animal;
use App\Models\Player;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Animal::factory(50)->create();
        Player::factory(20)->create();

    }
}