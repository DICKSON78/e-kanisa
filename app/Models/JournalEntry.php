<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'entry_number', 'entry_date', 'description', 'reference_type', 'reference_id',
        'status', 'total_debit', 'total_credit', 'created_by', 'posted_by',
        'posted_at', 'notes',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'total_debit' => 'decimal:2',
        'total_credit' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function lines() { return $this->hasMany(JournalEntryLine::class, 'journal_entry_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function poster() { return $this->belongsTo(User::class, 'posted_by'); }

    public function scopeDraft($query) { return $query->where('status', 'Draft'); }
    public function scopePosted($query) { return $query->where('status', 'Posted'); }

    public function isBalanced()
    {
        return abs($this->total_debit - $this->total_credit) < 0.01;
    }

    public function post(User $poster)
    {
        if (!$this->isBalanced()) {
            throw new \Exception('Journal entry is not balanced');
        }

        \DB::transaction(function () use ($poster) {
            $this->update([
                'status' => 'Posted',
                'posted_by' => $poster->id,
                'posted_at' => now(),
            ]);

            foreach ($this->lines as $line) {
                $account = $line->account;
                if ($line->debit > 0) {
                    $account->increment('current_balance', $line->debit);
                } else {
                    $account->decrement('current_balance', $line->credit);
                }

                AccountTransaction::create([
                    'account_id' => $line->account_id,
                    'journal_entry_id' => $this->id,
                    'transaction_date' => $this->entry_date,
                    'debit' => $line->debit,
                    'credit' => $line->credit,
                    'balance' => $account->current_balance,
                    'description' => $line->description ?? $this->description,
                ]);
            }
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($entry) {
            if (empty($entry->entry_number)) {
                $year = date('Y');
                $last = self::where('entry_number', 'like', "JE{$year}%")->orderBy('id', 'desc')->first();
                $seq = $last ? intval(substr($last->entry_number, -4)) + 1 : 1;
                $entry->entry_number = 'JE' . $year . str_pad($seq, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
