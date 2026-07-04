<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount', 'max_discount',
        'usage_limit', 'per_user_limit', 'used_count', 'valid_from', 'valid_until', 'is_active',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValidNow(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->valid_from && now()->lessThan($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && now()->greaterThan($this->valid_until)) {
            return false;
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_order_amount) {
            return 0;
        }

        $discount = $this->type === 'flat'
            ? (float) $this->value
            : $subtotal * ((float) $this->value / 100);

        if ($this->max_discount) {
            $discount = min($discount, (float) $this->max_discount);
        }

        return round(min($discount, $subtotal), 2);
    }
}
