<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'food_item_id', 'food_variant_id', 'quantity', 'price_snapshot'];

    public function foodItem(): BelongsTo
    {
        return $this->belongsTo(FoodItem::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(FoodVariant::class, 'food_variant_id');
    }
}
