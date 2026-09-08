<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberFollowup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'follow_up_type',
        'priority',
        'status',
        'subject',
        'description',
        'start_date',
        'last_contact_date',
        'follow_up_date',
        'action_taken',
        'outcome',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_contact_date' => 'date',
        'follow_up_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Inasubiri');
    }

    public function scopeOverdue($query)
    {
        return $query->where('follow_up_date', '<', now())
                     ->where('status', '!=', 'Imekamilika');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('follow_up_type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function getIsOverdueAttribute()
    {
        return $this->follow_up_date && $this->follow_up_date->isPast() && $this->status !== 'Imekamilika';
    }
}
