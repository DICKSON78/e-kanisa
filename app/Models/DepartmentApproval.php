<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DepartmentApproval extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'approval_number', 'department_id', 'requested_by', 'title', 'description',
        'amount_requested', 'amount_approved', 'expense_purpose', 'priority',
        'status', 'current_level', 'max_level', 'rejection_reason',
        'requested_date', 'approved_date', 'created_by',
    ];

    protected $casts = [
        'amount_requested' => 'decimal:2',
        'amount_approved' => 'decimal:2',
        'requested_date' => 'date',
        'approved_date' => 'date',
        'current_level' => 'integer',
        'max_level' => 'integer',
    ];

    public function department() { return $this->belongsTo(Department::class); }
    public function requester() { return $this->belongsTo(User::class, 'requested_by'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function steps() { return $this->hasMany(ApprovalStep::class, 'approval_id')->orderBy('level'); }
    public function completedSteps() { return $this->steps()->whereNotNull('acted_at'); }

    public function scopePending($query) { return $query->where('status', 'Inasubiri'); }

    public function nextPendingStep()
    {
        return $this->steps()->whereNull('acted_at')->orderBy('level')->first();
    }

    public function isFullyApproved()
    {
        return $this->steps()->whereNull('acted_at')->count() === 0
            && $this->steps()->where('decision', 'approved')->count() === $this->max_level;
    }

    public function canBeApprovedBy(User $user)
    {
        $nextStep = $this->nextPendingStep();
        if (!$nextStep) return false;
        return $user->role && $user->role->name === $nextStep->role_required;
    }

    public function approvalStages()
    {
        return $this->steps()->orderBy('level')->get()->map(function ($step) {
            return [
                'level' => $step->level,
                'role' => $step->role_required,
                'status' => $step->acted_at ? $step->decision : ($step->level === $this->current_level ? 'pending' : 'waiting'),
                'approver' => $step->approver ? $step->approver->name : null,
                'date' => $step->acted_at,
                'signature' => $step->signature_path ? asset('storage/' . $step->signature_path) : null,
                'comments' => $step->comments,
            ];
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($approval) {
            if (empty($approval->approval_number)) {
                $year = date('Y');
                $last = self::where('approval_number', 'like', "DAP{$year}%")->orderBy('id', 'desc')->first();
                $seq = $last ? intval(substr($last->approval_number, -4)) + 1 : 1;
                $approval->approval_number = 'DAP' . $year . str_pad($seq, 4, '0', STR_PAD_LEFT);
            }
            // Auto-determine approval chain from threshold
            $threshold = ApprovalThreshold::where('min_amount', '<=', $approval->amount_requested)
                ->where(function ($q) use ($approval) {
                    $q->whereNull('max_amount')->orWhere('max_amount', '>=', $approval->amount_requested);
                })
                ->where('is_active', true)
                ->first();
            if ($threshold) {
                $roles = $threshold->required_roles;
                $approval->max_level = count($roles);
            } else {
                // Default: Mhasibu then Mchungaji
                $approval->max_level = 2;
            }
        });

        static::created(function ($approval) {
            // Create approval steps based on threshold or default
            $threshold = ApprovalThreshold::where('min_amount', '<=', $approval->amount_requested)
                ->where(function ($q) use ($approval) {
                    $q->whereNull('max_amount')->orWhere('max_amount', '>=', $approval->amount_requested);
                })
                ->where('is_active', true)
                ->first();

            $roles = $threshold ? $threshold->required_roles : ['Mhasibu', 'Mchungaji'];

            foreach ($roles as $index => $role) {
                ApprovalStep::create([
                    'approval_id' => $approval->id,
                    'level' => $index + 1,
                    'role_required' => $role,
                ]);
            }
        });
    }
}
