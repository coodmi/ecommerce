<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    protected $fillable = ['name', 'charge', 'delivery_time', 'icon', 'is_active', 'sort_order'];

    protected $casts = [
        'charge' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public static function active()
    {
        return self::where('is_active', true)->orderBy('sort_order')->get();
    }
}
