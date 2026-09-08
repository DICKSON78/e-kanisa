<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryStructure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'member_id', 'basic_salary', 'allowance_housing', 'allowance_transport',
        'allowance_food', 'allowance_other', 'nssf_employee', 'nssf_employer',
        'nhif_amount', 'paye_amount', 'other_deductions', 'payment_method',
        'bank_name', 'bank_account', 'mobile_number', 'is_active', 'effective_date',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowance_housing' => 'decimal:2',
        'allowance_transport' => 'decimal:2',
        'allowance_food' => 'decimal:2',
        'allowance_other' => 'decimal:2',
        'nssf_employee' => 'decimal:2',
        'nhif_amount' => 'decimal:2',
        'paye_amount' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'is_active' => 'boolean',
        'effective_date' => 'date',
    ];

    public function member() { return $this->belongsTo(Member::class); }

    public function getTotalAllowancesAttribute()
    {
        return $this->allowance_housing + $this->allowance_transport + $this->allowance_food + $this->allowance_other;
    }

    public function getTotalDeductionsAttribute()
    {
        return $this->nssf_employee + $this->nhif_amount + $this->paye_amount + $this->other_deductions;
    }

    public function getGrossSalaryAttribute()
    {
        return $this->basic_salary + $this->total_allowances;
    }

    public function getNetSalaryAttribute()
    {
        return $this->gross_salary - $this->total_deductions;
    }
}
