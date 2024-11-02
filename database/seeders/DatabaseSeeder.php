<?php

namespace Database\Seeders;

use App\Models\Store;
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
            'name' => 'Test User',
            'email' => 'ronaldo@gmail.com',
            'password' => '12345',
        ]);

        Store::create([
            'name' => 'Test Store',
            'address' => 'Jl. Test No. 1',
            'phone' => '081234567890',
            'whatsapp' => '081234567890',
            'email' => '',
            'hours' => '08:00 - 17:00',
        ]);
    }
}
