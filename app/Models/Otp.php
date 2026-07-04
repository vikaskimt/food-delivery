<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['phone', 'code', 'expires_at', 'is_used', 'attempts'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }
}
