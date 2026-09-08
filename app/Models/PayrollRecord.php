<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payroll_period_id', 'member_id', 'salary_structure_id', 'basic_salary',
        'allowances', 'gross_salary', 'nssf_deduction', 'nhif_deduction',
        'paye_deduction', 'other_deductions', 'total_deductions', 'net_salary',
        'days_worked', 'days_absent', 'status', 'notes', 'recorded_by',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'nssf_deduction' => 'decimal:2',
        'nhif_deduction' => 'decimal:2',
        'paye_deduction' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function period() { return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id'); }
    public function member() { return $this->belongsTo(Member::class); }
    public function salaryStructure() { return $this->belongsTo(SalaryStructure::class, 'salary_structure_id'); }
    public function recorder() { return $this->belongsTo(User::class, 'recorded_by'); }
}
