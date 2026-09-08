<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'account_code', 'name', 'description', 'type', 'sub_type',
        'opening_balance', 'current_balance', 'is_active', 'is_system',
        'parent_account_id',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
        'is_system' => 'boolean',
    ];

    public function parent() { return $this->belongsTo(Account::class, 'parent_account_id'); }
    public function children() { return $this->hasMany(Account::class, 'parent_account_id'); }
    public function journalLines() { return $this->hasMany(JournalEntryLine::class, 'account_id'); }
    public function transactions() { return $this->hasMany(AccountTransaction::class, 'account_id'); }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeByType($query, $type) { return $query->where('type', $type); }

    public function getDisplayBalanceAttribute()
    {
        return number_format($this->current_balance, 2);
    }
}
