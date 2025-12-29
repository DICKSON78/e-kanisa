<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'expected_attendance',
        'actual_attendance',
        'budget',
        'is_active',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'budget' => 'decimal:2',
        'is_active' => 'boolean',
        'expected_attendance' => 'integer',
        'actual_attendance' => 'integer',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())->orderBy('event_date');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString())->orderBy('event_date', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }
}
