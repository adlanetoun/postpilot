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
        // 1. Free User (No Credits)
        User::factory()->create([
            'name' => 'Free User',
            'email' => 'free@example.com',
            'campaign_credits' => 0,
            'is_admin' => false,
            'password' => bcrypt('password'),
        ]);

        // 2. Pro User (With Credits)
        User::factory()->create([
            'name' => 'Pro User',
            'email' => 'pro@example.com',
            'campaign_credits' => 10,
            'is_admin' => false,
            'password' => bcrypt('password'),
        ]);

        // 3. Admin User (Access to Filament)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'campaign_credits' => 100,
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);
    }
}
