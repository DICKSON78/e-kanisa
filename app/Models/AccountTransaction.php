<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    protected $fillable = [
        'account_id', 'journal_entry_id', 'transaction_date',
        'debit', 'credit', 'balance', 'description',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function account() { return $this->belongsTo(Account::class); }
    public function journal() { return $this->belongsTo(JournalEntry::class, 'journal_entry_id'); }
}
