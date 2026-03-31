<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $page = \App\Models\Page::firstOrCreate(
            ['slug' => 'home'],
            ['name' => 'Home']
        );

        // Hero Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'hero'],
            ['content' => [
                'badge_text' => '🎉 New Collection 2026',
                'title_prefix' => 'Discover Your',
                'title_suffix' => 'Style Today',
                'description' => 'Shop the latest trends with unbeatable prices. Quality products, fast delivery, and exceptional service guaranteed.',
                'buttons' => [
                    [
                        'text' => 'Shop Now',
                        'url' => '/shop',
                        'style' => 'primary'
                    ],
                    [
                        'text' => 'Watch Video',
                        'url' => '#',
                        'style' => 'secondary'
                    ]
                ],
                'stats_happy_customers' => '50K+',
                'stats_products' => '1000+',
                'stats_rating' => '4.9★',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=500&h=600&fit=crop',
                'offer_label' => 'Special Offer',
                'offer_text' => '50% OFF'
            ]]
        );

        // Categories Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'categories'],
            ['content' => [
                'title' => 'Shop by Category',
                'description' => 'Explore our wide range of products'
            ]]
        );

        // Featured Products Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'featured_products'],
            ['content' => [
                'title' => 'Featured Products',
                'description' => 'Handpicked items just for you'
            ]]
        );

        // Promotional Banner Section (Flash Sale)
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'flash_sale'],
            ['content' => [
                'badge_text' => '⚡ Limited Time Offer',
                'title' => 'Flash Sale',
                'discount' => 'Up to 70% OFF',
                'description' => 'Don\'t miss out on our biggest sale of the season. Limited stock available!',
                'time_hours' => '23',
                'time_minutes' => '45',
                'time_seconds' => '30',
                'button_text' => 'Shop Sale Now',
                'button_url' => '/shop',
                'image' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&h=600&fit=crop'
            ]]
        );

        // Features Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'features'],
            ['content' => [
                'title' => 'Why Shop With Us',
                'items' => [
                    [
                        'icon' => 'fas fa-shipping-fast',
                        'title' => 'Free Shipping',
                        'description' => 'On all orders over $50'
                    ],
                    [
                        'icon' => 'fas fa-undo',
                        'title' => 'Easy Returns',
                        'description' => '30 days return policy'
                    ],
                    [
                        'icon' => 'fas fa-lock',
                        'title' => 'Secure Payment',
                        'description' => '100% secure transactions'
                    ],
                    [
                        'icon' => 'fas fa-headset',
                        'title' => '24/7 Support',
                        'description' => 'Dedicated customer service'
                    ]
                ]
            ]]
        );

        // Testimonials Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'testimonials'],
            ['content' => [
                'title' => 'What Our Customers Say',
                'description' => 'Real reviews from real customers',
                'items' => [
                    [
                        'name' => 'Sarah Johnson',
                        'role' => 'Verified Buyer',
                        'content' => 'Amazing quality and fast delivery! I\'m extremely satisfied with my purchase. The customer service was outstanding.',
                        'image' => 'https://i.pravatar.cc/100?img=1',
                        'rating' => 5
                    ],
                    [
                        'name' => 'Michael Chen',
                        'role' => 'Verified Buyer',
                        'content' => 'Best online shopping experience ever! The products exceeded my expectations. Will definitely shop again.',
                        'image' => 'https://i.pravatar.cc/100?img=3',
                        'rating' => 5
                    ],
                    [
                        'name' => 'Emily Rodriguez',
                        'role' => 'Verified Buyer',
                        'content' => 'Great prices and authentic products. The whole process was smooth from ordering to delivery. Highly recommended!',
                        'image' => 'https://i.pravatar.cc/100?img=5',
                        'rating' => 5
                    ]
                ]
            ]]
        );
    }
}
