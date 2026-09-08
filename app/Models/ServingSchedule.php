<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServingSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'schedule_date',
        'service_type',
        'status',
        'created_by',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function assignments()
    {
        return $this->hasMany(ServingAssignment::class, 'schedule_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('schedule_date', '>=', now()->toDateString())
                     ->where('status', 'Active');
    }

    public function scopePast($query)
    {
        return $query->where('schedule_date', '<', now()->toDateString());
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('schedule_date', $date);
    }

    public function getAssignmentCountAttribute()
    {
        return $this->assignments()->count();
    }
}
