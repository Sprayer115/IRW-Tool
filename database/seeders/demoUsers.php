<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class demoUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'demo@example.com',
            'email' => 'demo@example.com',
            'password' => bcrypt('demo1234'),
        ]);
    }
}
