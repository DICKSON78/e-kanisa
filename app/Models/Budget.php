<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'budget_number',
        'title',
        'description',
        'year',
        'month',
        'expense_category_id',
        'budgeted_amount',
        'actual_amount',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'budgeted_amount' => 'decimal:2',
        'actual_amount' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->budgeted_amount - $this->actual_amount;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->budgeted_amount <= 0) return 0;
        return round(($this->actual_amount / $this->budgeted_amount) * 100, 1);
    }

    public function getMonthNameAttribute()
    {
        if (!$this->month) return 'Bajeti ya Mwaka';
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Machi', 4 => 'Aprili',
            5 => 'Mei', 6 => 'Juni', 7 => 'Julai', 8 => 'Agosti',
            9 => 'Septemba', 10 => 'Oktoba', 11 => 'Novemba', 12 => 'Desemba',
        ];
        return $months[$this->month] ?? '';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($budget) {
            if (empty($budget->budget_number)) {
                $year = $budget->year ?? date('Y');
                $last = self::where('budget_number', 'like', "BDG{$year}%")
                    ->orderBy('id', 'desc')
                    ->first();

                $sequence = 1;
                if ($last) {
                    $sequence = intval(substr($last->budget_number, -4)) + 1;
                }
                $budget->budget_number = 'BDG' . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
