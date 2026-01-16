<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        "name",
        "price",
        "category_id",
        "in_stock",
        "rating",
    ];

    protected $casts = [
        "category_id" => "integer",
        "price" => "float",
        "in_stock" => "boolean",
        "rating" => "float",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
