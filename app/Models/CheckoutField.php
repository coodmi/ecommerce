<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutField extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'name',
        'type',
        'placeholder',
        'options',
        'is_required',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'options' => 'array',
    ];
}
