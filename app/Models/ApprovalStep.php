<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ApprovalStep extends Model
{
    protected $fillable = [
        'approval_id', 'request_id', 'level', 'role_required', 'approver_user_id',
        'decision', 'comments', 'digital_signature_hash', 'signature_path',
        'ip_address', 'device_fingerprint', 'otp_verified', 'acted_at',
    ];

    protected $casts = [
        'level' => 'integer',
        'otp_verified' => 'boolean',
        'acted_at' => 'datetime',
    ];

    public function approval() { return $this->belongsTo(DepartmentApproval::class, 'approval_id'); }
    public function request() { return $this->belongsTo(Request::class, 'request_id'); }
    public function approver() { return $this->belongsTo(User::class, 'approver_user_id'); }

    public static function generateSignatureHash(int $userId, int $approvalId, int $level, string $timestamp): string
    {
        return hash('sha256', implode('|', [$userId, $approvalId, $level, $timestamp, config('app.key')]));
    }
}
