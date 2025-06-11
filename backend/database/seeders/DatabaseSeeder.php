<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user only - no example projects for production
        if (!User::where('email', 'artur@ferreiracruz.com')->exists()) {
            User::create([
                'name' => 'Artur Ferreira Cruz',
                'email' => 'artur@ferreiracruz.com',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'change-me-in-production')),
                'email_verified_at' => now(),
            ]);
        }
    }
}
