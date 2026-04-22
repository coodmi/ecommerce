<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'delivery_charge',
        'category_id',
        'is_active',
        'stock_quantity',
        'sku',
        'brand_id',
        'rating',
        'is_deal',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'base_price'      => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'is_deal'         => 'boolean',
    ];

    // Automatically generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Helper methods
    public function hasColors()
    {
        return $this->colors()->exists();
    }

    public function hasSizes()
    {
        return $this->sizes()->exists();
    }

    public function hasVariants()
    {
        return $this->variants()->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
