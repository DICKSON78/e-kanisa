<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalThreshold extends Model
{
    protected $fillable = [
        'min_amount', 'max_amount', 'required_roles', 'expected_hours', 'is_active',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'required_roles' => 'array',
        'is_active' => 'boolean',
        'expected_hours' => 'integer',
    ];

    public static function findForAmount(float $amount): ?self
    {
        return static::where('min_amount', '<=', $amount)
            ->where(function ($q) use ($amount) {
                $q->whereNull('max_amount')->orWhere('max_amount', '>=', $amount);
            })
            ->where('is_active', true)
            ->first();
    }
}
