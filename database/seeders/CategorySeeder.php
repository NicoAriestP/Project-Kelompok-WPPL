<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // categories for task lists
        $categories = [
            'Personal',
            'Work',
            'Shopping',
            'Wishlist',
            'Movies',
            'Books',
            'Groceries',
            'Health',
            'Fitness',
            'Travel',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
            ]);
        }
    }
}
