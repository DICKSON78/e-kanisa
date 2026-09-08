<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'request_number',
        'title',
        'description',
        'department',
        'amount_requested',
        'amount_approved',
        'status',
        'approval_notes',
        'requested_date',
        'approved_date',
        'requested_by',
        'approved_by',
        'current_level',
        'max_level',
    ];

    protected $casts = [
        'amount_requested' => 'decimal:2',
        'amount_approved' => 'decimal:2',
        'requested_date' => 'date',
        'approved_date' => 'date',
        'current_level' => 'integer',
        'max_level' => 'integer',
    ];

    // Relationships
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function steps()
    {
        return $this->hasMany(ApprovalStep::class, 'request_id')->orderBy('level');
    }

    public function completedSteps()
    {
        return $this->steps()->whereNotNull('acted_at');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Inasubiri');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Imeidhinishwa');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Imekataliwa');
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    // Multi-level approval methods
    public function nextPendingStep()
    {
        return $this->steps()->whereNull('acted_at')->orderBy('level')->first();
    }

    public function isFullyApproved()
    {
        return $this->steps()->whereNull('acted_at')->count() === 0
            && $this->max_level > 0
            && $this->steps()->where('decision', 'approved')->count() === $this->max_level;
    }

    public function canBeApprovedBy($user)
    {
        $nextStep = $this->nextPendingStep();
        if (!$nextStep) return false;
        $userRole = $user->role->name ?? ($user->roles->first()->name ?? null);
        return $userRole === $nextStep->role_required;
    }

    public function getApprovalStages()
    {
        return $this->steps()->orderBy('level')->get()->map(function ($step) {
            return [
                'level' => $step->level,
                'role' => $step->role_required,
                'status' => $step->acted_at ? $step->decision : ($step->level == $this->current_level ? 'pending' : 'waiting'),
                'approver' => $step->approver ? $step->approver->name : null,
                'date' => $step->acted_at,
                'signature' => $step->signature_path ? asset('storage/' . $step->signature_path) : null,
                'signature_hash' => $step->digital_signature_hash,
                'comments' => $step->comments,
            ];
        });
    }
}
