<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
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

        User::factory()->create([
            'name' => 'artur',
            'email' => 'artur@ferreiracruz.com',
            'password'=> bcrypt('1'),
        ]);
        Project::factory()->create([
            'title' => 'Project 1',
            'description' => 'Description for project 1',
            'demo_link' => 'https://example.com/demo1',
            'github_link' => 'https://github.com/arturict/portfolio',
            'image' => 'https://example.com/image1.jpg',
            'status' => 'current',
        ]);
        Project::factory()->create([
            'title' => 'Project 2',
            'description' => 'Description for project 2',
            'demo_link' => 'https://example.com/demo2',
            'github_link' => 'https://github.com/arturict/portfolio',
            'image' => 'https://example.com/image2.jpg',
            'status' => 'finished',
        ]);
        Project::factory()->create([
            'title' => 'Project 3',
            'description' => 'Description for project 3',
            'demo_link' => 'https://example.com/demo3',
            'github_link' => 'https://github.com/arturict/portfolio',
            'image' => 'https://example.com/image3.jpg',
            'status' => 'planned',
        ]);
        
    }
}
