<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $brandIds = Brand::pluck('id')->toArray();
        
        $productsData = [
            // Electronics
            [
                'category' => 'Electronics',
                'name' => 'Premium Wireless Headphones',
                'price' => 199.99,
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1484704849700-f032a568e944?q=80&w=800&auto=format&fit=crop',
                ],
                'colors' => [
                    ['name' => 'Black', 'code' => '#000000'],
                    ['name' => 'Silver', 'code' => '#C0C0C0'],
                ],
                'sizes' => [],
            ],
            [
                'category' => 'Electronics',
                'name' => 'Smart Fitness Watch',
                'price' => 149.50,
                'images' => [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=800&auto=format&fit=crop',
                ],
                'colors' => [
                    ['name' => 'Rose Gold', 'code' => '#B76E79'],
                    ['name' => 'Space Grey', 'code' => '#3D3D3D'],
                ],
                'sizes' => [],
            ],
            [
                'category' => 'Electronics',
                'name' => 'Noise Cancelling Earbuds',
                'price' => 129.99,
                'images' => ['https://images.unsplash.com/photo-1590658268037-6bf12165a8df?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],
            [
                'category' => 'Electronics',
                'name' => 'Ultra Portable Speaker',
                'price' => 79.00,
                'images' => ['https://images.unsplash.com/photo-1608156639585-b3a032ef9689?q=80&w=800&auto=format&fit=crop'],
                'colors' => [['name' => 'Blue', 'code' => '#0000FF']],
                'sizes' => [],
            ],

            // Fashion
            [
                'category' => 'Fashion',
                'name' => 'Classic Cotton T-Shirt',
                'price' => 25.00,
                'images' => [
                    'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=800&auto=format&fit=crop',
                ],
                'colors' => [
                    ['name' => 'White', 'code' => '#FFFFFF'],
                    ['name' => 'Navy', 'code' => '#000080'],
                ],
                'sizes' => ['S', 'M', 'L', 'XL'],
            ],
            [
                'category' => 'Fashion',
                'name' => 'Slim Fit Denim Jeans',
                'price' => 55.00,
                'images' => ['https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => ['30', '32', '34', '36'],
            ],
            [
                'category' => 'Fashion',
                'name' => 'Urban Leather Jacket',
                'price' => 150.00,
                'images' => ['https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800&auto=format&fit=crop'],
                'colors' => [['name' => 'Brown', 'code' => '#8B4513']],
                'sizes' => ['M', 'L', 'XL'],
            ],
            [
                'category' => 'Fashion',
                'name' => 'Elite Performance Running Shoes',
                'price' => 110.00,
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=800&auto=format&fit=crop',
                ],
                'colors' => [
                    ['name' => 'Red', 'code' => '#FF0000'],
                    ['name' => 'Black', 'code' => '#000000'],
                ],
                'sizes' => ['8', '9', '10', '11'],
            ],

            // Home & Living
            [
                'category' => 'Home & Living',
                'name' => 'Programmable Coffee Maker',
                'price' => 85.00,
                'images' => ['https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],
            [
                'category' => 'Home & Living',
                'name' => 'High-Speed Blender',
                'price' => 120.00,
                'images' => ['https://images.unsplash.com/photo-1585238341267-1cfec2046a55?q=80&w=800&auto=format&fit=crop'],
                'colors' => [['name' => 'Grey', 'code' => '#808080']],
                'sizes' => [],
            ],
            [
                'category' => 'Home & Living',
                'name' => 'Egyptian Cotton Towel Set',
                'price' => 45.00,
                'images' => ['https://images.unsplash.com/photo-1583912267670-65ca5ad3bf4a?q=80&w=800&auto=format&fit=crop'],
                'colors' => [
                    ['name' => 'Beige', 'code' => '#F5F5DC'],
                    ['name' => 'Teal', 'code' => '#008080'],
                ],
                'sizes' => [],
            ],
            [
                'category' => 'Home & Living',
                'name' => 'Modern Minimalist Table Lamp',
                'price' => 35.00,
                'images' => ['https://images.unsplash.com/photo-1507473885765-e6ed657db944?q=80&w=800&auto=format&fit=crop'],
                'colors' => [['name' => 'White', 'code' => '#FFFFFF']],
                'sizes' => [],
            ],

            // Beauty & Health
            [
                'category' => 'Beauty & Health',
                'name' => 'Organic Face Moisturizer',
                'price' => 28.00,
                'images' => ['https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],
            [
                'category' => 'Beauty & Health',
                'name' => 'Ionic Hair Dryer',
                'price' => 65.00,
                'images' => ['https://images.unsplash.com/photo-1522338140262-f46f5912018a?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],
            [
                'category' => 'Beauty & Health',
                'name' => 'Eco-Friendly Yoga Mat',
                'price' => 40.00,
                'images' => ['https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?q=80&w=800&auto=format&fit=crop'],
                'colors' => [
                    ['name' => 'Purple', 'code' => '#800080'],
                    ['name' => 'Green', 'code' => '#008000'],
                ],
                'sizes' => [],
            ],
            [
                'category' => 'Beauty & Health',
                'name' => 'Smart Electric Toothbrush',
                'price' => 95.00,
                'images' => ['https://images.unsplash.com/photo-1552044081-4b13ee638cfb?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],

            // Sports & Outdoors
            [
                'category' => 'Sports & Outdoors',
                'name' => '4-Person Camping Tent',
                'price' => 175.00,
                'images' => ['https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=800&auto=format&fit=crop'],
                'colors' => [['name' => 'Orange', 'code' => '#FFA500']],
                'sizes' => [],
            ],
            [
                'category' => 'Sports & Outdoors',
                'name' => 'Adventure Hiking Backpack',
                'price' => 89.00,
                'images' => ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],
            [
                'category' => 'Sports & Outdoors',
                'name' => 'Insulated Water Bottle',
                'price' => 22.00,
                'images' => ['https://images.unsplash.com/photo-1602143301051-53738e4e94af?q=80&w=800&auto=format&fit=crop'],
                'colors' => [
                    ['name' => 'Blue', 'code' => '#0000FF'],
                    ['name' => 'Pink', 'code' => '#FFC0CB'],
                ],
                'sizes' => ['500ml', '1L'],
            ],
            [
                'category' => 'Sports & Outdoors',
                'name' => 'Adjustable Dumbbell Set',
                'price' => 240.00,
                'images' => ['https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?q=80&w=800&auto=format&fit=crop'],
                'colors' => [],
                'sizes' => [],
            ],
        ];

        foreach ($productsData as $p) {
            DB::beginTransaction();
            try {
                $category = $categories->where('name', $p['category'])->first();
                if (!$category) continue;
                
                $product = Product::create([
                    'name' => $p['name'],
                    'slug' => Str::slug($p['name']),
                    'description' => "This is a premium product from the " . $p['category'] . " category. High quality and durable.",
                    'base_price' => $p['price'],
                    'category_id' => $category->id,
                    'stock_quantity' => rand(10, 100),
                    'sku' => strtoupper(Str::random(8)),
                    'brand_id' => !empty($brandIds) ? $brandIds[array_rand($brandIds)] : null,
                    'rating' => rand(3, 5),
                    'is_active' => true,
                ]);

                // Create Images
                foreach ($p['images'] as $index => $imageUrl) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imageUrl,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }

                // Create Colors
                $colorModels = [];
                foreach ($p['colors'] as $color) {
                    $colorModels[] = ProductColor::create([
                        'product_id' => $product->id,
                        'color_name' => $color['name'],
                        'color_code' => $color['code'],
                    ]);
                }

                // Create Sizes
                $sizeModels = [];
                foreach ($p['sizes'] as $sizeName) {
                    $sizeModels[] = ProductSize::create([
                        'product_id' => $product->id,
                        'size_name' => $sizeName,
                    ]);
                }

                // Create Variants if colors or sizes exist
                if (!empty($colorModels) && !empty($sizeModels)) {
                    foreach ($colorModels as $c) {
                        foreach ($sizeModels as $s) {
                            ProductVariant::create([
                                'product_id' => $product->id,
                                'color_id' => $c->id,
                                'size_id' => $s->id,
                                'price' => $p['price'] + rand(5, 15),
                                'stock_quantity' => rand(5, 20),
                                'sku' => $product->sku . '-' . strtoupper($c->color_name[0]) . '-' . $s->size_name,
                            ]);
                        }
                    }
                } elseif (!empty($colorModels)) {
                    foreach ($colorModels as $c) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id' => $c->id,
                            'price' => $p['price'],
                            'stock_quantity' => rand(10, 30),
                            'sku' => $product->sku . '-' . strtoupper($c->color_name[0]),
                        ]);
                    }
                } elseif (!empty($sizeModels)) {
                    foreach ($sizeModels as $s) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size_id' => $s->id,
                            'price' => $p['price'],
                            'stock_quantity' => rand(10, 30),
                            'sku' => $product->sku . '-' . $s->size_name,
                        ]);
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
