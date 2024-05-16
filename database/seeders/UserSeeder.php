<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory([
            'leader_id' => 1,
        ])->create();
        User::factory()->create([
            'email' => 'user@gmail.com',
            'leader_id' => 1,
        ]);
        User::factory()->create([
            'email' => 'user2@gmail.com',
            'leader_id' => 12,
        ]);
        User::factory()->create([
            'email' => 'user3@gmail.com',
            'leader_id' => 12,
        ]);
    }
}
