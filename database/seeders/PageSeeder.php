<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deals Page
        $dealsPage = \App\Models\Page::updateOrCreate(
            ['slug' => 'deals'],
            ['name' => 'Deals']
        );

        // Deals - Hero Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $dealsPage->id,
                'key' => 'hero'
            ],
            [
                'content' => [
                    'badge_text' => 'Limited Time Only',
                    'title' => 'Super Hot Deals',
                    'description' => 'Unbeatable prices on your favorite items. Grab them before they\'re gone!',
                ]
            ]
        );

        // Deals - Lightning Deals Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $dealsPage->id,
                'key' => 'lightning_deals'
            ],
            [
                'content' => [
                    'title' => 'Lightning Fast Deals',
                    'subtitle' => 'Offers expire soon • Limited quantities',
                    'countdown_hours' => 24,
                ]
            ]
        );

        // Deals - Top Deals Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $dealsPage->id,
                'key' => 'top_deals'
            ],
            [
                'content' => [
                    'title' => 'TOP DEALS OF THE DAY',
                    'description' => 'Our most popular discounted items, updated daily for your shopping pleasure.',
                ]
            ]
        );

        // Deals - Category Deals Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $dealsPage->id,
                'key' => 'category_deals'
            ],
            [
                'content' => [
                    'title' => 'Deals by Category',
                    'subtitle' => 'Discover amazing offers in every category',
                ]
            ]
        );

        // Deals - Newsletter/CTA Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $dealsPage->id,
                'key' => 'newsletter'
            ],
            [
                'content' => [
                    'title' => 'DON\'T MISS THE NEXT DEAL!',
                    'description' => 'Be the first to know about our exclusive limited-time discounts and upcoming sales events.',
                    'button_text' => 'Shop Now',
                    'button_url' => '/shop',
                ]
            ]
        );

        // Category Page
        $categoryPage = \App\Models\Page::updateOrCreate(
            ['slug' => 'categories'],
            ['name' => 'Categories']
        );

        // Hero Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $categoryPage->id,
                'key' => 'hero'
            ],
            [
                'content' => [
                    'badge_text' => '1000+ Premium Products',
                    'title_prefix' => 'Explore Our',
                    'title_suffix' => 'Amazing Categories',
                    'description' => 'Discover thousands of quality products across multiple categories. Find exactly what you\'re looking for with ease.',
                    'button_text' => 'Start Shopping',
                    'bg_class' => 'bg-gradient-to-br from-purple-900 via-purple-700 to-pink-600',
                    'stats_categories_label' => 'Categories',
                    'stats_products_label' => 'Products',
                    'stats_support_label' => 'Support',
                ]
            ]
        );

        // Banner / Shop CTA Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $categoryPage->id,
                'key' => 'banner'
            ],
            [
                'content' => [
                    'title' => 'Ready to Upgrade Your Lifestyle?',
                    'description' => 'Discover a world of premium products curated just for you. From trending fashion to cutting-edge electronics, find everything you love in one place.',
                    'button_text' => 'Shop Now',
                    'bg_class' => 'bg-gradient-to-r from-purple-800 to-pink-700',
                ]
            ]
        );

        // About Us Page
        $aboutPage = \App\Models\Page::updateOrCreate(
            ['slug' => 'about-us'],
            ['name' => 'About Us']
        );

        // About Us - Hero Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'hero'
            ],
            [
                'content' => [
                    'badge_text' => 'Our Story',
                    'title' => 'About Our Company',
                    'subtitle' => 'Building Excellence Since Day One',
                    'description' => 'We are dedicated to providing the best products and services to our customers. Our journey started with a simple vision: to make quality accessible to everyone.',
                    'buttons' => [
                        [
                            'text' => 'Learn More',
                            'url' => '#story',
                            'style' => 'primary'
                        ],
                        [
                            'text' => 'Contact Us',
                            'url' => '/contact',
                            'style' => 'secondary'
                        ]
                    ],
                    'bg_class' => 'bg-gradient-to-br from-blue-900 via-blue-700 to-indigo-600',
                ]
            ]
        );

        // About Us - Stats Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'stats'
            ],
            [
                'content' => [
                    'title' => 'Our Impact in Numbers',
                    'stats' => [
                        [
                            'number' => '10K+',
                            'label' => 'Happy Customers',
                            'icon' => 'fa-users'
                        ],
                        [
                            'number' => '500+',
                            'label' => 'Products',
                            'icon' => 'fa-box'
                        ],
                        [
                            'number' => '50+',
                            'label' => 'Team Members',
                            'icon' => 'fa-user-tie'
                        ],
                        [
                            'number' => '99%',
                            'label' => 'Satisfaction Rate',
                            'icon' => 'fa-star'
                        ]
                    ]
                ]
            ]
        );

        // About Us - Story Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'story'
            ],
            [
                'content' => [
                    'title' => 'Our Journey',
                    'subtitle' => 'How It All Started',
                    'content' => 'Founded with a passion for excellence, our company has grown from a small startup to a trusted name in the industry. We believe in innovation, quality, and customer satisfaction above all else.',
                    'features' => [
                        [
                            'title' => 'Innovation First',
                            'description' => 'We constantly innovate to bring you the latest and best products.',
                            'icon' => 'fa-lightbulb'
                        ],
                        [
                            'title' => 'Quality Assured',
                            'description' => 'Every product goes through rigorous quality checks.',
                            'icon' => 'fa-certificate'
                        ],
                        [
                            'title' => 'Customer Focused',
                            'description' => 'Your satisfaction is our top priority.',
                            'icon' => 'fa-heart'
                        ]
                    ]
                ]
            ]
        );

        // About Us - Values Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'values'
            ],
            [
                'content' => [
                    'title' => 'Our Core Values',
                    'subtitle' => 'What Drives Us Every Day',
                    'values' => [
                        [
                            'title' => 'Integrity',
                            'description' => 'We conduct our business with honesty and transparency.',
                            'icon' => 'fa-handshake'
                        ],
                        [
                            'title' => 'Excellence',
                            'description' => 'We strive for excellence in everything we do.',
                            'icon' => 'fa-trophy'
                        ],
                        [
                            'title' => 'Innovation',
                            'description' => 'We embrace change and continuously improve.',
                            'icon' => 'fa-rocket'
                        ],
                        [
                            'title' => 'Teamwork',
                            'description' => 'We believe in the power of collaboration.',
                            'icon' => 'fa-people-group'
                        ]
                    ]
                ]
            ]
        );

        // About Us - Team Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'team'
            ],
            [
                'content' => [
                    'title' => 'Meet Our Team',
                    'subtitle' => 'The People Behind Our Success',
                    'members' => [
                        [
                            'name' => 'John Doe',
                            'position' => 'CEO & Founder',
                            'bio' => 'Visionary leader with 15+ years of experience.',
                            'image' => '',
                            'social' => [
                                'linkedin' => '#',
                                'twitter' => '#'
                            ]
                        ],
                        [
                            'name' => 'Jane Smith',
                            'position' => 'Chief Operating Officer',
                            'bio' => 'Expert in operations and business development.',
                            'image' => '',
                            'social' => [
                                'linkedin' => '#',
                                'twitter' => '#'
                            ]
                        ],
                        [
                            'name' => 'Mike Johnson',
                            'position' => 'Head of Technology',
                            'bio' => 'Tech enthusiast driving innovation.',
                            'image' => '',
                            'social' => [
                                'linkedin' => '#',
                                'twitter' => '#'
                            ]
                        ]
                    ]
                ]
            ]
        );

        // About Us - Why Choose Us Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'why_choose_us'
            ],
            [
                'content' => [
                    'title' => 'Why Choose Us',
                    'subtitle' => 'What Makes Us Different',
                    'reasons' => [
                        [
                            'title' => 'Best Quality',
                            'description' => 'We never compromise on quality. Every product is carefully selected and tested.',
                            'icon' => 'fa-gem'
                        ],
                        [
                            'title' => 'Fast Delivery',
                            'description' => 'Get your orders delivered quickly with our efficient logistics network.',
                            'icon' => 'fa-shipping-fast'
                        ],
                        [
                            'title' => '24/7 Support',
                            'description' => 'Our customer support team is always ready to help you.',
                            'icon' => 'fa-headset'
                        ],
                        [
                            'title' => 'Secure Payment',
                            'description' => 'Shop with confidence using our secure payment gateway.',
                            'icon' => 'fa-shield-halved'
                        ],
                        [
                            'title' => 'Easy Returns',
                            'description' => 'Not satisfied? Return products hassle-free within 30 days.',
                            'icon' => 'fa-rotate-left'
                        ],
                        [
                            'title' => 'Best Prices',
                            'description' => 'Competitive pricing with regular deals and discounts.',
                            'icon' => 'fa-tag'
                        ]
                    ]
                ]
            ]
        );

        // About Us - CTA Section
        \App\Models\PageSection::updateOrCreate(
            [
                'page_id' => $aboutPage->id,
                'key' => 'cta'
            ],
            [
                'content' => [
                    'title' => 'Ready to Get Started?',
                    'description' => 'Join thousands of satisfied customers and experience the difference today.',
                    'buttons' => [
                        [
                            'text' => 'Shop Now',
                            'url' => '/shop',
                            'style' => 'primary'
                        ],
                        [
                            'text' => 'Contact Us',
                            'url' => '/contact',
                            'style' => 'secondary'
                        ]
                    ],
                    'bg_class' => 'bg-gradient-to-r from-purple-800 to-pink-700',
                ]
            ]
        );

        // Contact Us Page
        $contactPage = \App\Models\Page::updateOrCreate(
            ['slug' => 'contact-us'],
            ['name' => 'Contact Us']
        );

        // Contact Us - Hero Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $contactPage->id, 'key' => 'hero'],
            [
                'content' => [
                    'badge_text' => 'GET IN TOUCH',
                    'title_prefix' => 'Let\'s Start a',
                    'title_suffix' => 'Conversation',
                    'description' => 'We\'re here to help! Whether you have questions, feedback, or need support, our team is ready to assist you 24/7.',
                    'stats' => [
                        ['value' => '24/7', 'label' => 'Support'],
                        ['value' => '<2h', 'label' => 'Response'],
                        ['value' => '98%', 'label' => 'Satisfied'],
                    ]
                ]
            ]
        );

        // Contact Us - Contact Methods
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $contactPage->id, 'key' => 'contact_info'],
            [
                'content' => [
                    'cards' => [
                        [
                            'icon' => 'fa-phone-alt',
                            'title' => 'Call Us',
                            'info' => '+880 1234-567890',
                            'subinfo' => 'Mon-Fri, 9AM-6PM',
                            'color' => 'blue',
                            'link' => 'tel:+8801234567890'
                        ],
                        [
                            'icon' => 'fa-envelope',
                            'title' => 'Email Us',
                            'info' => 'support@ecomalpha.com',
                            'subinfo' => '24/7 Email Support',
                            'color' => 'purple',
                            'link' => 'mailto:support@ecomalpha.com'
                        ],
                        [
                            'icon' => 'fa-map-marker-alt',
                            'title' => 'Visit Us',
                            'info' => '123 Commerce Street',
                            'subinfo' => 'Dhaka, Bangladesh',
                            'color' => 'pink',
                            'link' => '#map'
                        ],
                        [
                            'icon' => 'fa-comments',
                            'title' => 'Live Chat',
                            'info' => 'Chat with us now',
                            'subinfo' => 'Average wait: 2 min',
                            'color' => 'green',
                            'link' => '#chat'
                        ],
                    ]
                ]
            ]
        );

        // Contact Us - Form Area
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $contactPage->id, 'key' => 'form_area'],
            [
                'content' => [
                    'badge' => 'SEND MESSAGE',
                    'title' => 'Drop Us a Message',
                    'description' => 'Fill out the form below and we\'ll get back to you within 24 hours',
                ]
            ]
        );

        // Contact Us - Sidebar
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $contactPage->id, 'key' => 'sidebar'],
            [
                'content' => [
                    'faq_title' => 'Quick Answers',
                    'faq_desc' => 'Looking for quick answers? Check out our FAQ section for instant help.',
                    'faq_link_text' => 'Visit FAQ Center',
                    'faq_link_url' => '#',
                    
                    'hours_title' => 'Office Hours',
                    'hours' => [
                        ['day' => 'Monday - Friday', 'time' => '9:00 AM - 6:00 PM', 'is_closed' => false],
                        ['day' => 'Saturday', 'time' => '10:00 AM - 4:00 PM', 'is_closed' => false],
                        ['day' => 'Sunday', 'time' => 'Closed', 'is_closed' => true],
                    ],
                    'hours_note' => 'Email support is available 24/7, even outside office hours',

                    'social_title' => 'Follow Us',
                    'social_desc' => 'Stay connected and get the latest updates on our social channels',
                    'socials' => [
                        ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => '#'],
                        ['icon' => 'fab fa-twitter', 'name' => 'Twitter', 'url' => '#'],
                        ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => '#'],
                        ['icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn', 'url' => '#'],
                        ['icon' => 'fab fa-youtube', 'name' => 'YouTube', 'url' => '#'],
                    ]
                ]
            ]
        );

        // Contact Us - Map Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $contactPage->id, 'key' => 'map'],
            [
                'content' => [
                    'badge' => 'FIND US',
                    'title' => 'Visit Our Office',
                    'description' => 'Drop by our headquarters for an in-person meeting with our team',
                    'address' => '123 Commerce Street, Gulshan, Dhaka 1212, Bangladesh',
                    'embed_html' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d68147.9560172176!2d90.38636365281127!3d23.800413630203746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c0e96fce29dd%3A0x6ccd9e51aba9e64d!2sMirpur-1%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1768396668376!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                ]
            ]
        );

        // Contact Us - CTA Section
        \App\Models\PageSection::updateOrCreate(
            ['page_id' => $contactPage->id, 'key' => 'cta'],
            [
                'content' => [
                    'title' => 'Still Have Questions?',
                    'description' => 'Our support team is here to help you 24/7. Don\'t hesitate to reach out!',
                    'buttons' => [
                        [
                            'text' => 'Call Now',
                            'url' => 'tel:+8801234567890',
                            'style' => 'primary',
                            'icon' => 'fas fa-phone-alt'
                        ],
                        [
                            'text' => 'Email Support',
                            'url' => 'mailto:support@ecomalpha.com',
                            'style' => 'secondary',
                            'icon' => 'fas fa-envelope'
                        ]
                    ]
                ]
            ]
        );
    }
}
