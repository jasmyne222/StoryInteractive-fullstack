<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StorySeeder::class,
            // InteractiveStorySeeder::class  // Commentez ou supprimez cette ligne si présente
        ]);
    }
}