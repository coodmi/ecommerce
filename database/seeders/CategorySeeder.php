<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fashion',
                'description' => 'Trendy clothing, shoes and accessories for everyone.',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b830c6050?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Electronics',
                'description' => 'Latest gadgets, smartphones, laptops and more.',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Home & Living',
                'description' => 'Enhance your living space with our premium home essentials.',
                'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Beauty & Health',
                'description' => 'Top-rated skincare, makeup and wellness products.',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdd403348?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Gear up for your next adventure with our sports equipment.',
                'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Fun and educational toys for kids of all ages.',
                'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Books & Stationery',
                'description' => 'Books, notebooks, and office supplies for every need.',
                'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Parts, accessories, and tools for your car or motorcycle.',
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Groceries',
                'description' => 'Fresh produce, pantry staples, and daily essentials.',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Jewelry & Watches',
                'description' => 'Elegant jewelry and premium timepieces.',
                'image' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Pet Supplies',
                'description' => 'Everything you need for your furry friends.',
                'image' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Garden & DIY',
                'description' => 'Tools and supplies for your garden and home projects.',
                'image' => 'https://images.unsplash.com/photo-1416879895691-14022a7935eb?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Kitchen Appliances',
                'description' => 'Modern appliances to make cooking easier.',
                'image' => 'https://images.unsplash.com/photo-1556910103-1c02745a30bf?q=80&w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Baby & Toddler',
                'description' => 'Essentials for babies and toddlers.',
                'image' => 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Office Furniture',
                'description' => 'Comfortable and stylish furniture for your workspace.',
                'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']], // Check by name to avoid duplicates
                [
                    'slug' => Str::slug($category['name']),
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'is_active' => true,
                    'is_popular' => $category['is_popular'] ?? false,
                ]
            );
        }
    }
}
