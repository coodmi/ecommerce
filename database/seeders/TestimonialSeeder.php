<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name'        => 'Sarah Johnson',
                'designation' => 'Verified Customer',
                'message'     => 'Amazing quality products and super fast delivery! I\'ve been shopping here for months and never disappointed. Highly recommend to everyone!',
                'rating'      => 5,
                'avatar'      => null,
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Michael Chen',
                'designation' => 'Verified Customer',
                'message'     => 'Best online shopping experience ever! The website is easy to navigate, prices are competitive, and quality exceeds expectations.',
                'rating'      => 5,
                'avatar'      => null,
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Emily Rodriguez',
                'designation' => 'Verified Customer',
                'message'     => 'Incredible variety of products and unbeatable deals! I love the flash sales and the loyalty program. Highly recommend!',
                'rating'      => 5,
                'avatar'      => null,
                'sort_order'  => 3,
            ],
            [
                'name'        => 'David Wilson',
                'designation' => 'Verified Customer',
                'message'     => 'Outstanding service and premium quality products. The delivery is always on time and the packaging is excellent.',
                'rating'      => 5,
                'avatar'      => null,
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Lisa Park',
                'designation' => 'Verified Customer',
                'message'     => 'I\'ve tried many online stores but this one stands out. Great prices, fast shipping, and excellent customer support!',
                'rating'      => 5,
                'avatar'      => null,
                'sort_order'  => 5,
            ],
            [
                'name'        => 'James Miller',
                'designation' => 'Verified Customer',
                'message'     => 'Absolutely love this store! The product quality is top-notch and the deals are unbeatable. Will definitely shop again.',
                'rating'      => 5,
                'avatar'      => null,
                'sort_order'  => 6,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create(array_merge($data, ['is_active' => true]));
        }
    }
}
