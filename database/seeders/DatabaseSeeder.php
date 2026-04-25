<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            CheckoutFieldSeeder::class,
            DeliveryZoneSeeder::class,
            PageSeeder::class,
            HomePageSeeder::class,
            FooterSeeder::class,
            HeaderSeeder::class,
        ]);
    }
}
