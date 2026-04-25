<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use Illuminate\Database\Seeder;

class DeliveryZoneSeeder extends Seeder
{
    public function run(): void
    {
        DeliveryZone::create([
            'name' => 'Inside Dhaka',
            'charge' => 80,
            'delivery_time' => 'Delivery within 1-2 days',
            'icon' => 'fa-map-marker-alt',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        DeliveryZone::create([
            'name' => 'Outside Dhaka',
            'charge' => 140,
            'delivery_time' => 'Delivery within 3-5 days',
            'icon' => 'fa-truck',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
