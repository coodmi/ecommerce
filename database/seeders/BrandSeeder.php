<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Nike' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200&h=200&fit=crop',
            'Adidas' => 'https://images.unsplash.com/photo-1521093470119-a3ac9f9fb029?w=200&h=200&fit=crop',
            'Apple' => 'https://images.unsplash.com/photo-1510878933023-e2e2e3942fb0?w=200&h=200&fit=crop',
            'Samsung' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=200&h=200&fit=crop',
            'Sony' => 'https://images.unsplash.com/photo-1544099858-75feeb57f0ce?w=200&h=200&fit=crop',
            'Gucci' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=200&h=200&fit=crop',
            'Prada' => 'https://images.unsplash.com/photo-1594913785162-e678537db36e?w=200&h=200&fit=crop',
            'Zara' => 'https://images.unsplash.com/photo-1626214041065-950c4db2876b?w=200&h=200&fit=crop',
            'H&M' => 'https://images.unsplash.com/photo-1594913785202-58389bbc3ee8?w=200&h=200&fit=crop',
            'L\'Oreal' => 'https://images.unsplash.com/photo-1596462502278-27bfaf410911?w=200&h=200&fit=crop',
            'Puma' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=200&h=200&fit=crop',
            'Levis' => 'https://images.unsplash.com/photo-1605518216938-7c31b7b14ad0?w=200&h=200&fit=crop'
        ];

        foreach ($brands as $brandName => $logoUrl) {
            Brand::create([
                'name' => $brandName,
                'slug' => Str::slug($brandName),
                'logo' => $logoUrl,
                'is_active' => true,
            ]);
        }
    }
}
