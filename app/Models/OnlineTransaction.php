<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_number',
        'member_id',
        'amount',
        'payment_method',
        'reference_number',
        'phone_number',
        'status',
        'purpose',
        'income_category_id',
        'description',
        'metadata',
        'recorded_by',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Inasubiri');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Imekamilika');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeByDateRange($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($txn) {
            if (empty($txn->transaction_number)) {
                $year = date('Y');
                $last = self::where('transaction_number', 'like', "TXN{$year}%")
                    ->orderBy('id', 'desc')
                    ->first();

                $sequence = 1;
                if ($last) {
                    $sequence = intval(substr($last->transaction_number, -4)) + 1;
                }
                $txn->transaction_number = 'TXN' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
