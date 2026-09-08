<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'visitor_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'gender',
        'address',
        'city',
        'church_from',
        'visit_date',
        'service_type',
        'status',
        'referred_by',
        'notes',
        'follow_up_status',
        'follow_up_notes',
        'assigned_to',
        'recorded_by',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('visit_date', $date);
    }

    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('visit_date', $year)
                     ->whereMonth('visit_date', $month);
    }

    public function scopePendingFollowUp($query)
    {
        return $query->where('follow_up_status', 'Inasubiri');
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($visitor) {
            if (empty($visitor->visitor_number)) {
                $year = date('Y');
                $last = self::where('visitor_number', 'like', "VIS{$year}%")
                    ->orderBy('id', 'desc')
                    ->first();

                $sequence = 1;
                if ($last) {
                    $sequence = intval(substr($last->visitor_number, -4)) + 1;
                }
                $visitor->visitor_number = 'VIS' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
