<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            'task 1',
            'taks 2',
            'task 3',
        ];

        foreach ($tasks as $task) {
            Task::create(['name' => $task]);
        }
    }
}
