<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollPeriod extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'month', 'year', 'status', 'total_gross', 'total_deductions',
        'total_net', 'pay_date', 'created_by', 'processed_by', 'approved_by',
        'processed_at', 'approved_at',
    ];

    protected $casts = [
        'total_gross' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'total_net' => 'decimal:2',
        'pay_date' => 'date',
        'processed_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function records() { return $this->hasMany(PayrollRecord::class, 'payroll_period_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function processor() { return $this->belongsTo(User::class, 'processed_by'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

    public function getMonthNameAttribute()
    {
        $months = [1=>'Januari',2=>'Februari',3=>'Machi',4=>'Aprili',5=>'Mei',6=>'Juni',7=>'Julai',8=>'Agosti',9=>'Septemba',10=>'Oktoba',11=>'Novemba',12=>'Desemba'];
        return $months[$this->month] ?? '';
    }
}
