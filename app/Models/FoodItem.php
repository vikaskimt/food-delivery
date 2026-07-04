<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodItem extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'image', 'price', 'is_veg', 'is_available', 'sort_order',
    ];

    protected $casts = [
        'is_veg' => 'boolean',
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(FoodVariant::class);
    }
}
