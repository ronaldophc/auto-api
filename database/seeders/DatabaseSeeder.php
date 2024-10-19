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
        User::factory()->count(50)->create();

        Store::created([
            "name" => "Auto Legend",
            "logo" => "",
            "address" => "Rua Castro 135",
            "phone" => "(42) 984147386",
            "whatsapp" => "(42) 984147386",
            "instagram" => "teste",
            "tiktok" => "teste",
            "facebook" => "teste",
            "google_maps" => "teste",
            "email" => "ronaldo@gmail.com"
        ]);
    }
}
