<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transfer_number',
        'member_id',
        'transfer_type',
        'from_church',
        'to_church',
        'from_pastor',
        'to_pastor',
        'transfer_date',
        'reason',
        'status',
        'notes',
        'documents',
        'approved_by',
        'created_by',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'documents' => 'array',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('transfer_type', $type);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Inasubiri');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Imeidhinishwa');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transfer) {
            if (empty($transfer->transfer_number)) {
                $year = date('Y');
                $last = self::where('transfer_number', 'like', "TRF{$year}%")
                    ->orderBy('id', 'desc')
                    ->first();

                $sequence = 1;
                if ($last) {
                    $sequence = intval(substr($last->transfer_number, -4)) + 1;
                }
                $transfer->transfer_number = 'TRF' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
