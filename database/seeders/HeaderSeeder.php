<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageSection;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Header page if it doesn't exist
        $headerPage = Page::updateOrCreate(
            ['slug' => 'header'],
            ['name' => 'Global Header']
        );

        // 1. Top Bar Section
        PageSection::updateOrCreate(
            ['page_id' => $headerPage->id, 'key' => 'top_bar'],
            [
                'content' => [
                    'phone' => '+880 1234-567890',
                    'email' => 'info@ecomalpha.com',
                    'announcement' => 'Free Shipping on Orders Over $50',
                ]
            ]
        );

        // 2. Navigation Menu Section
        PageSection::updateOrCreate(
            ['page_id' => $headerPage->id, 'key' => 'navigation'],
            [
                'content' => [
                    'items' => [
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'Shop', 'url' => '/shop'],
                        ['name' => 'Categories', 'url' => '/categories'],
                        ['name' => 'Deals', 'url' => '/deals'],
                        ['name' => 'About', 'url' => '/about'],
                        ['name' => 'Contact', 'url' => '/contact'],
                    ]
                ]
            ]
        );

        // 3. Brand Config (for Logo)
        PageSection::updateOrCreate(
            ['page_id' => $headerPage->id, 'key' => 'brand'],
            [
                'content' => [
                    'logo' => null, // Default will be used if null
                    'logo_height' => '14', // Default h-14
                ]
            ]
        );
    }
}
