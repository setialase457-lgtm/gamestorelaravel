<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'game',
        'rank_name',
        'description',
        'price',
        'stock',
        'rating',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'rating' => 'decimal:1',
            'stock' => 'integer',
        ];
    }
}

