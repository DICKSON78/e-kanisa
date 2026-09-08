<?php

namespace App\Http\Controllers;

use App\Models\PayrollPeriod;
use App\Models\PayrollRecord;
use App\Models\SalaryStructure;
use App\Models\Member;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    // ========== PAYROLL PERIODS ==========
    public function index(Request $request)
    {
        $periods = PayrollPeriod::withCount('records')->orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(15);

        $stats = [
            'total_periods' => PayrollPeriod::count(),
            'completed' => PayrollPeriod::where('status', 'Completed')->count(),
            'paid' => PayrollPeriod::where('status', 'Paid')->count(),
            'total_paid' => PayrollPeriod::where('status', 'Paid')->sum('total_net'),
        ];

        if ($request->ajax()) {
            return view('panel.payroll._periods-table', compact('periods'));
        }

        return view('panel.payroll.index', compact('periods', 'stats'));
    }

    public function createPeriod()
    {
        return view('panel.payroll.create-period');
    }

    public function storePeriod(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020',
            'pay_date' => 'required|date',
        ], [
            'month.required' => 'Tafadhali chagua mwezi',
            'year.required' => 'Tafadhali ingiza mwaka',
            'pay_date.required' => 'Tafadhali weka tarehe ya malipo',
        ]);

        $exists = PayrollPeriod::where('month', $validated['month'])->where('year', $validated['year'])->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Kipindi hiki tayari kipo');
        }

        $months = [1=>'Januari',2=>'Februari',3=>'Machi',4=>'Aprili',5=>'Mei',6=>'Juni',7=>'Julai',8=>'Agosti',9=>'Septemba',10=>'Oktoba',11=>'Novemba',12=>'Desemba'];

        PayrollPeriod::create([
            'name' => $months[$validated['month']] . ' ' . $validated['year'],
            'month' => $validated['month'],
            'year' => $validated['year'],
            'pay_date' => $validated['pay_date'],
            'status' => 'Draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('payroll.index')->with('success', 'Kipindi kipya kimeundwa');
    }

    // ========== SALARY STRUCTURES ==========
    public function salaryStructures(Request $request)
    {
        $structures = SalaryStructure::with('member')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            return view('panel.payroll._structures-table', compact('structures'));
        }

        return view('panel.payroll.salary-structures', compact('structures'));
    }

    public function createStructure()
    {
        $members = Member::active()->get(['id', 'first_name', 'last_name', 'member_number']);
        return view('panel.payroll.create-structure', compact('members'));
    }

    public function storeStructure(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id|unique:salary_structures,member_id',
            'basic_salary' => 'required|numeric|min:0',
            'allowance_housing' => 'nullable|numeric|min:0',
            'allowance_transport' => 'nullable|numeric|min:0',
            'allowance_food' => 'nullable|numeric|min:0',
            'allowance_other' => 'nullable|numeric|min:0',
            'nssf_employee' => 'nullable|numeric|min:0',
            'nhif_amount' => 'nullable|numeric|min:0',
            'paye_amount' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:Bank Transfer,Mobile Money,Cash',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:100',
            'mobile_number' => 'nullable|string|max:20',
            'effective_date' => 'required|date',
        ]);

        SalaryStructure::create($validated);

        return redirect()->route('payroll.salary-structures')->with('success', 'Muundo wa mshahara umeundwa');
    }

    public function editStructure($id)
    {
        $structure = SalaryStructure::findOrFail($id);
        return view('panel.payroll.edit-structure', compact('structure'));
    }

    public function updateStructure(Request $request, $id)
    {
        $structure = SalaryStructure::findOrFail($id);

        $validated = $request->validate([
            'basic_salary' => 'required|numeric|min:0',
            'allowance_housing' => 'nullable|numeric|min:0',
            'allowance_transport' => 'nullable|numeric|min:0',
            'allowance_food' => 'nullable|numeric|min:0',
            'allowance_other' => 'nullable|numeric|min:0',
            'nssf_employee' => 'nullable|numeric|min:0',
            'nhif_amount' => 'nullable|numeric|min:0',
            'paye_amount' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        $structure->update($validated);

        return redirect()->route('payroll.salary-structures')->with('success', 'Muundo umesasishwa');
    }

    // ========== PAYROLL PROCESSING ==========
    public function process($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);

        if ($period->status !== 'Draft') {
            return redirect()->back()->with('error', 'Kipindi hiki hakiwezi kuchakatwa');
        }

        $structures = SalaryStructure::where('is_active', true)->get();

        if ($structures->isEmpty()) {
            return redirect()->back()->with('error', 'Hakuna miundo ya mishahara. Tafadhali weka miundo kwanza');
        }

        foreach ($structures as $structure) {
            $exists = PayrollRecord::where('payroll_period_id', $period->id)
                ->where('member_id', $structure->member_id)
                ->exists();

            if (!$exists) {
                $grossSalary = $structure->basic_salary + $structure->allowance_housing + $structure->allowance_transport + $structure->allowance_food + $structure->allowance_other;
                $totalDeductions = $structure->nssf_employee + $structure->nhif_amount + $structure->paye_amount + $structure->other_deductions;

                PayrollRecord::create([
                    'payroll_period_id' => $period->id,
                    'member_id' => $structure->member_id,
                    'salary_structure_id' => $structure->id,
                    'basic_salary' => $structure->basic_salary,
                    'allowances' => $structure->allowance_housing + $structure->allowance_transport + $structure->allowance_food + $structure->allowance_other,
                    'gross_salary' => $grossSalary,
                    'nssf_deduction' => $structure->nssf_employee,
                    'nhif_deduction' => $structure->nhif_amount,
                    'paye_deduction' => $structure->paye_amount,
                    'other_deductions' => $structure->other_deductions,
                    'total_deductions' => $totalDeductions,
                    'net_salary' => $grossSalary - $totalDeductions,
                    'days_worked' => 30,
                    'status' => 'Draft',
                    'recorded_by' => auth()->id(),
                ]);
            }
        }

        // Update period totals
        $period->update([
            'status' => 'Processing',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'total_gross' => $period->records()->sum('gross_salary'),
            'total_deductions' => $period->records()->sum('total_deductions'),
            'total_net' => $period->records()->sum('net_salary'),
        ]);

        return redirect()->route('payroll.show', $period->id)->with('success', 'Malipo yamechakatwa. Wafanyakazi ' . $period->records()->count() . ' wamesajiliwa');
    }

    public function show($periodId)
    {
        $period = PayrollPeriod::with(['records.member', 'records.salaryStructure', 'processor', 'approver'])->findOrFail($periodId);
        $records = $period->records()->with('member')->orderBy('created_at')->get();

        return view('panel.payroll.show-period', compact('period', 'records'));
    }

    public function approvePeriod($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);

        if ($period->status !== 'Processing') {
            return redirect()->back()->with('error', 'Kipindi hiki hakiwezi kuthibitishwa');
        }

        $period->update([
            'status' => 'Completed',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Malipo yamethibitishwa');
    }

    public function markPaid($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);

        if ($period->status !== 'Completed') {
            return redirect()->back()->with('error', 'Kwanza thibitisha kipindi');
        }

        $period->records()->update(['status' => 'Paid']);
        $period->update(['status' => 'Paid']);

        return redirect()->back()->with('success', 'Malipo yamerekodwa kama yaliyolipwa');
    }

    public function payslip($recordId)
    {
        $record = PayrollRecord::with(['member', 'period', 'salaryStructure'])->findOrFail($recordId);
        return view('panel.payroll.payslip', compact('record'));
    }
}
