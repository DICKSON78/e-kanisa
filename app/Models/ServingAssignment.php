<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServingAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'member_id',
        'role',
        'position',
        'status',
        'notes',
    ];

    public function schedule()
    {
        return $this->belongsTo(ServingSchedule::class, 'schedule_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'Imekubaliwa');
    }
}
