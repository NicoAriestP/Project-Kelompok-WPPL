<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // clear cache dulu sebelum seed
        \Artisan::call('cache:clear');

        $this->call([
            CategorySeeder::class, 
            UserSeeder::class, 
            TaskSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}
