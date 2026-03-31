<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $footerPage = Page::updateOrCreate(
            ['slug' => 'footer'],
            ['name' => 'Global Footer']
        );

        // 1. Company Info
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'company_info'],
            [
                'content' => [
                    'description' => 'Your premium shopping destination for quality products. We bring you the best deals, authentic products, and exceptional customer service.',
                    'items' => [
                        ['name' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => '#'],
                        ['name' => 'Twitter', 'icon' => 'fab fa-twitter', 'url' => '#'],
                        ['name' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => '#'],
                        ['name' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => '#'],
                        ['name' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => '#'],
                    ]
                ]
            ]
        );

        // 2. Quick Links
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'quick_links'],
            [
                'content' => [
                    'title' => 'Quick Links',
                    'items' => [
                        ['name' => 'About Us', 'url' => '/about'],
                        ['name' => 'Contact Us', 'url' => '/contact'],
                        ['name' => 'Shop', 'url' => '/shop'],
                    ]
                ]
            ]
        );

        // 3. Customer Service
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'customer_service'],
            [
                'content' => [
                    'title' => 'Customer Service',
                    'items' => [
                        ['name' => 'Categories', 'url' => '/categories'],
                        ['name' => 'Deals', 'url' => '/deals'],
                        ['name' => 'Returns', 'url' => '/returns'],
                    ]
                ]
            ]
        );

        // 4. Policies
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'policies'],
            [
                'content' => [
                    'title' => 'Policies',
                    'items' => [
                        ['name' => 'Privacy Policy', 'url' => '/privacy-policy'],
                        ['name' => 'Terms & Conditions', 'url' => '/terms-conditions'],
                        ['name' => 'Refund Policy', 'url' => '/refund-policy'],
                    ]
                ]
            ]
        );

        // 5. Contact Info
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'contact_info'],
            [
                'content' => [
                    'title' => 'Contact Info',
                    'address' => '123 Shopping Street, Dhaka 1200, Bangladesh',
                    'phone' => '+880 1234-567890',
                ]
            ]
        );

        // 6. Newsletter
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'newsletter'],
            [
                'content' => [
                    'title' => 'Subscribe to Our Newsletter',
                    'description' => 'Get the latest updates on new products and upcoming sales',
                ]
            ]
        );

        // 7. Bottom Footer
        PageSection::updateOrCreate(
            ['page_id' => $footerPage->id, 'key' => 'bottom_footer'],
            [
                'content' => [
                    'copyright_text' => '2026 Shankhobazar. All rights reserved.',
                    'credit_text' => 'Designed and developed by',
                    'developer_name' => 'Alphainno',
                    'developer_url' => 'https://alphainno.com',
                ]
            ]
        );
    }
}
