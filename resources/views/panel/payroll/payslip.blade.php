@extends('layouts.app')

@section('title', 'Stakabadhi ya Mshahara - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <a href="{{ route('payroll.show', $record->period_id) }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-file-invoice" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Stakabadhi ya Mshahara</h1>
                <p class="text-sm text-gray-500">{{ $record->member->first_name ?? '' }} {{ $record->member->last_name ?? '' }}</p>
            </div>
        </div>
        <button onclick="window.print()" class="rx-btn rx-btn-secondary flex items-center gap-2">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    <!-- Payslip Content -->
    <div class="rx-card rounded-2xl overflow-hidden" id="payslip-content">
        <!-- ROC Header -->
        <div class="p-6 text-center" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex items-center justify-center gap-3 mb-2">
                <img src="{{ asset('images/roc_logo.jpeg') }}" alt="ROC Logo" class="w-12 h-12 rounded-lg object-contain bg-white p-1">
                <div class="text-left">
                    <h2 class="text-xl font-bold text-white">ROC - Reality of Christ</h2>
                    <p class="text-sm text-white/60">Stakabadhi ya Mshahara</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <!-- Period & Pay Date -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Kipindi</p>
                    <p class="text-lg font-bold" style="color: #360958">{{ $record->period->name ?? '' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Tarehe ya Malipo</p>
                    <p class="text-lg font-medium text-gray-900">{{ $record->period->pay_date ? \Carbon\Carbon::parse($record->period->pay_date)->format('d/m/Y') : '-' }}</p>
                </div>
            </div>

            <!-- Employee Info -->
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-user text-xs" style="color: #efc120"></i> Taarifa za Mfanyakazi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-400">Jina</p>
                        <p class="text-sm font-medium text-gray-900">{{ $record->member->first_name ?? '' }} {{ $record->member->last_name ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Namba ya Muumini</p>
                        <p class="text-sm font-medium text-gray-900 font-mono">{{ $record->member->member_number ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Idara</p>
                        <p class="text-sm font-medium text-gray-900">{{ $record->member->department ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @php
                $salary = $record->salaryStructure;
                $basic = $salary->basic_salary ?? 0;
                $housing = $salary->allowance_housing ?? 0;
                $transport = $salary->allowance_transport ?? 0;
                $food = $salary->allowance_food ?? 0;
                $otherAllow = $salary->allowance_other ?? 0;
                $totalAllowances = $housing + $transport + $food + $otherAllow;
                $gross = $basic + $totalAllowances;
                $nssf = $record->nssf_deduction ?? $salary->nssf_employee ?? 0;
                $nhif = $record->nhif_deduction ?? $salary->nhif_amount ?? 0;
                $paye = $record->paye_deduction ?? $salary->paye_amount ?? 0;
                $otherDed = $record->other_deductions ?? $salary->other_deductions ?? 0;
                $totalDeductions = $nssf + $nhif + $paye + $otherDed;
                $net = $gross - $totalDeductions;
            @endphp

            <!-- Earnings -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-arrow-up text-xs" style="color: #16a34a"></i> Mapato
                </h3>
                <table class="w-full">
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">Mshahara wa Msingi</td>
                            <td class="py-2.5 text-sm font-medium text-gray-900 text-right font-mono">{{ number_format($basic, 0) }} TSh</td>
                        </tr>
                        @if($housing > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">Allowance ya Nyumba</td>
                            <td class="py-2.5 text-sm font-medium text-gray-900 text-right font-mono">{{ number_format($housing, 0) }} TSh</td>
                        </tr>
                        @endif
                        @if($transport > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">Allowance ya Usafiri</td>
                            <td class="py-2.5 text-sm font-medium text-gray-900 text-right font-mono">{{ number_format($transport, 0) }} TSh</td>
                        </tr>
                        @endif
                        @if($food > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">Allowance ya Chakula</td>
                            <td class="py-2.5 text-sm font-medium text-gray-900 text-right font-mono">{{ number_format($food, 0) }} TSh</td>
                        </tr>
                        @endif
                        @if($otherAllow > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">Allowance Nyingine</td>
                            <td class="py-2.5 text-sm font-medium text-gray-900 text-right font-mono">{{ number_format($otherAllow, 0) }} TSh</td>
                        </tr>
                        @endif
                        <tr style="border-top: 2px solid #efc120;">
                            <td class="py-3 text-sm font-bold text-gray-900">Jumla ya Mapato (GROSS)</td>
                            <td class="py-3 text-sm font-bold text-right font-mono" style="color: #360958">{{ number_format($gross, 0) }} TSh</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Deductions -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-arrow-down text-xs" style="color: #ef4444"></i> Kodi
                </h3>
                <table class="w-full">
                    <tbody>
                        @if($nssf > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">NSSF</td>
                            <td class="py-2.5 text-sm font-medium text-red-600 text-right font-mono">{{ number_format($nssf, 0) }} TSh</td>
                        </tr>
                        @endif
                        @if($nhif > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">NHIF</td>
                            <td class="py-2.5 text-sm font-medium text-red-600 text-right font-mono">{{ number_format($nhif, 0) }} TSh</td>
                        </tr>
                        @endif
                        @if($paye > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">PAYE</td>
                            <td class="py-2.5 text-sm font-medium text-red-600 text-right font-mono">{{ number_format($paye, 0) }} TSh</td>
                        </tr>
                        @endif
                        @if($otherDed > 0)
                        <tr class="border-b border-gray-100">
                            <td class="py-2.5 text-sm text-gray-600">Kodi Nyingine</td>
                            <td class="py-2.5 text-sm font-medium text-red-600 text-right font-mono">{{ number_format($otherDed, 0) }} TSh</td>
                        </tr>
                        @endif
                        <tr style="border-top: 2px solid #efc120;">
                            <td class="py-3 text-sm font-bold text-gray-900">Jumla ya Kodi</td>
                            <td class="py-3 text-sm font-bold text-red-600 text-right font-mono">{{ number_format($totalDeductions, 0) }} TSh</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Net Salary Summary -->
            <div class="p-5 rounded-xl mb-6" style="background: rgba(22,163,74,0.06); border: 1px solid rgba(22,163,74,0.15);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Mshahara wa Mikono</p>
                            <p class="text-xs text-gray-500">GROSS - Kodi = NET</p>
                        </div>
                    </div>
                    <p class="text-2xl font-bold font-mono" style="color: #16a34a">{{ number_format($net, 0) }} TSh</p>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-credit-card text-xs" style="color: #efc120"></i> Taarifa za Malipo
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-400">Njia ya Malipo</p>
                        <p class="text-sm font-medium text-gray-900">{{ $salary->payment_method ?? '-' }}</p>
                    </div>
                    @if(($salary->payment_method ?? '') === 'Benki')
                    <div>
                        <p class="text-xs text-gray-400">Benki</p>
                        <p class="text-sm font-medium text-gray-900">{{ $salary->bank_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Akaunti</p>
                        <p class="text-sm font-medium text-gray-900 font-mono">{{ $salary->bank_account ?? '-' }}</p>
                    </div>
                    @elseif(($salary->payment_method ?? '') === 'Pesa ya Simu')
                    <div>
                        <p class="text-xs text-gray-400">Namba ya Simu</p>
                        <p class="text-sm font-medium text-gray-900 font-mono">{{ $salary->mobile_number ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-4 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-400">Stakabadhi hii imeundwa na Mfumo wa ROC - Reality of Christ</p>
                <p class="text-xs text-gray-400 mt-1">Tarehe ya Uundaji: {{ $record->created_at ? $record->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .sidebar-overlay, .header, .notification-container, .content-area > div:first-child {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    .content-area {
        padding: 0 !important;
    }
    #payslip-content {
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
    }
    .rx-card {
        box-shadow: none !important;
        border: none !important;
    }
    .btn-print-hide {
        display: none !important;
    }
    @page {
        margin: 10mm;
    }
}
</style>
@endsection
