<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'osama said',
            'email' => 'osama.saieed@gmail.com',
            'password' => 'password',
        ]);
        \App\Models\User::factory(10)->create();
    }
}
