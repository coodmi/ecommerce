<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['page_id', 'key', 'content'];

    protected $casts = [
        'content' => 'array', // Use simple array cast for JSON column
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
