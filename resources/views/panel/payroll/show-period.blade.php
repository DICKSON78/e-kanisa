@extends('layouts.app')

@section('title', $period->name . ' - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('payroll.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-money-check-alt" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $period->name }}</h1>
            <p class="text-sm text-gray-500">Mishahara ya mwezi</p>
        </div>
        <div class="flex items-center gap-3 shrink-0 flex-wrap justify-end">
            @if($period->status === 'Draft')
            <form method="POST" action="{{ route('payroll.process', $period->id) }}" id="processForm" class="inline">
                @csrf
                <button type="button" onclick="submitProcess()" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-cogs"></i> Chaksha
                </button>
            </form>
            @endif
            @if($period->status === 'Processing')
            <form method="POST" action="{{ route('payroll.approve', $period->id) }}" id="approveForm" class="inline">
                @csrf
                <button type="button" onclick="submitApprove()" class="rx-btn rx-btn-primary flex items-center gap-2" style="background: #7c3aed; color: white;">
                    <i class="fas fa-check-double"></i> Idhini
                </button>
            </form>
            @endif
            @if($period->status === 'Completed')
            <form method="POST" action="{{ route('payroll.pay', $period->id) }}" id="payForm" class="inline">
                @csrf
                <button type="button" onclick="submitPay()" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-hand-holding-usd"></i> Weka alama ya malipo
                </button>
            </form>
            @endif
            @if($period->records->count() > 0)
            <a href="{{ route('payroll.print-all-payslips', $period->id) }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-print"></i> Payslip ya kila mtu
            </a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c);">
                    <i class="fas fa-calendar-alt text-2xl md:text-3xl" style="color: #360958"></i>
                </div>
                <div class="flex-1 text-white min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold truncate">{{ $period->name }}</h2>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                @if($period->status === 'Draft')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(107,114,128,0.2); color: #d1d5db;">Draft</span>
                                @elseif($period->status === 'Processing')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(59,130,246,0.2); color: #93c5fd;">Processing</span>
                                @elseif($period->status === 'Completed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(34,197,94,0.2); color: #4ade80;">Completed</span>
                                @elseif($period->status === 'Paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(239,193,32,0.2); color: #fbbf24;">Paid</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 md:px-8 py-4 border-b border-gray-100 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mwezi</p>
                    <p class="text-sm font-medium text-gray-900">{{ $period->month_name ?? $period->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-purple-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Mwaka</p>
                    <p class="text-sm font-medium text-gray-900">{{ $period->year }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar-check text-emerald-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Tarehe ya Malipo</p>
                    <p class="text-sm font-medium text-gray-900">{{ $period->pay_date ? \Carbon\Carbon::parse($period->pay_date)->format('d/m/Y') : '-' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-arrow-up text-amber-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">GROSS</p>
                    <p class="text-sm font-medium font-mono" style="color: #360958">{{ number_format($period->total_gross ?? 0, 0) }} TSh</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-arrow-down text-red-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Kodi</p>
                    <p class="text-sm font-medium font-mono text-red-600">{{ number_format($period->total_deductions ?? 0, 0) }} TSh</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">NET</p>
                    <p class="text-sm font-bold font-mono" style="color: #16a34a">{{ number_format($period->total_net ?? 0, 0) }} TSh</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-list text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Mistari ya Mishahara</h3>
                    <span class="rx-badge rx-badge-default text-xs">{{ $period->records->count() }} mistari</span>
                </div>

                @if($period->records->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="py-3 px-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jina</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Msingi</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Allowances</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">GROSS</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Kodi</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">NHIF</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">NSSF</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Zingine</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumla Kodi</th>
                                <th class="py-3 px-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">NET</th>
                                <th class="py-3 px-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Hali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($period->records as $index => $record)
                            @php
                                $salary = $record->salaryStructure;
                                $basic = $salary->basic_salary ?? 0;
                                $housing = $salary->allowance_housing ?? 0;
                                $transport = $salary->allowance_transport ?? 0;
                                $food = $salary->allowance_food ?? 0;
                                $other = $salary->allowance_other ?? 0;
                                $totalAllowances = $housing + $transport + $food + $other;
                                $gross = $basic + $totalAllowances;
                                $nssf = $record->nssf_deduction ?? $salary->nssf_employee ?? 0;
                                $nhif = $record->nhif_deduction ?? $salary->nhif_amount ?? 0;
                                $paye = $record->paye_deduction ?? $salary->paye_amount ?? 0;
                                $otherDed = $record->other_deductions ?? $salary->other_deductions ?? 0;
                                $totalDeductions = $nssf + $nhif + $paye + $otherDed;
                                $net = $gross - $totalDeductions;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-4"><span class="text-sm text-gray-500">{{ $index + 1 }}</span></td>
                                <td class="py-3 px-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $record->member->first_name ?? '' }} {{ $record->member->last_name ?? '' }}</div>
                                    <div class="text-xs text-gray-500">{{ $record->member->member_number ?? '' }}</div>
                                </td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-gray-900">{{ number_format($basic, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-gray-900">{{ number_format($totalAllowances, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm font-semibold" style="color: #360958">{{ number_format($gross, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($paye, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($nhif, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($nssf, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($otherDed, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm font-medium text-red-600">{{ number_format($totalDeductions, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm font-bold" style="color: #16a34a">{{ number_format($net, 0) }}</span></td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('payroll.payslip', $record->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Stakabadhi">
                                        <i class="fas fa-file-invoice text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="font-bold border-t-2" style="border-color: #efc120; background: rgba(239,193,32,0.04);">
                                <td class="py-3 px-4" colspan="2"><span class="text-sm text-gray-900">JUMLA</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-gray-900">{{ number_format($period->records->sum('salaryStructure.basic_salary'), 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-gray-900">-</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm" style="color: #360958">{{ number_format($period->total_gross ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($period->total_paye ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($period->total_nhif ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($period->total_nssf ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($period->total_other_deductions ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm text-red-600">{{ number_format($period->total_deductions ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4 text-right"><span class="font-mono text-sm" style="color: #16a34a">{{ number_format($period->total_net ?? 0, 0) }}</span></td>
                                <td class="py-3 px-4"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="rx-empty">
                    <div class="rx-empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="rx-empty-title">Hakuna Mistari ya Mishahara</h3>
                    <p class="rx-empty-description">Kipindi hii hakina rekodi za mishahara bado. Chakata kipindi kuunda mistari.</p>
                </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-pie text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Takwimu</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-users w-4 text-center text-gray-400"></i> Idadi ya Wafanyakazi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->records->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-arrow-up w-4 text-center text-gray-400"></i> Jumla GROSS</span>
                            <span class="text-sm font-bold font-mono" style="color: #360958">{{ number_format($period->total_gross ?? 0, 0) }} TSh</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-arrow-down w-4 text-center text-gray-400"></i> Jumla Kodi</span>
                            <span class="text-sm font-bold font-mono text-red-600">{{ number_format($period->total_deductions ?? 0, 0) }} TSh</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-check-circle w-4 text-center text-gray-400"></i> Jumla NET</span>
                            <span class="text-sm font-bold font-mono" style="color: #16a34a">{{ number_format($period->total_net ?? 0, 0) }} TSh</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa za Usindikaji</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-user-plus w-4 text-center text-gray-400"></i> Imeundwa na</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->creator->name ?? '-' }}</span>
                        </div>
                        @if($period->created_at)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center text-gray-400"></i> Tarehe ya Uundaji</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-cogs w-4 text-center text-gray-400"></i> Imesindikwa na</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->processor->name ?? '-' }}</span>
                        </div>
                        @if($period->processed_at)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center text-gray-400"></i> Tarehe ya Usindikaji</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->processed_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-check-double w-4 text-center text-gray-400"></i> Imeidhinishwa na</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->approver->name ?? '-' }}</span>
                        </div>
                        @if($period->approved_at)
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center text-gray-400"></i> Tarehe ya Idhini</span>
                            <span class="text-sm font-medium text-gray-900">{{ $period->approved_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-bolt text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Vitendo</h3>
                </div>
                <div class="p-4 space-y-2">
                    @if($period->status === 'Draft')
                    <form method="POST" action="{{ route('payroll.process', $period->id) }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group text-left" onclick="event.preventDefault(); submitProcess();">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-cogs text-blue-500 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Chakata Mishahara</p>
                                <p class="text-xs text-gray-400">Hesabu mishahara yote</p>
                            </div>
                        </button>
                    </form>
                    @endif
                    @if($period->status === 'Processing')
                    <form method="POST" action="{{ route('payroll.approve', $period->id) }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group text-left" onclick="event.preventDefault(); submitApprove();">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-check-double text-purple-500 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Idhinisha Kipindi</p>
                                <p class="text-xs text-gray-400">Thibitisha mishahara</p>
                            </div>
                        </button>
                    </form>
                    @endif
                    @if($period->status === 'Completed')
                    <form method="POST" action="{{ route('payroll.pay', $period->id) }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group text-left" onclick="event.preventDefault(); submitPay();">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: rgba(239,193,32,0.1)">
                                <i class="fas fa-hand-holding-usd text-sm" style="color: #efc120"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Weka Alama ya Malipo</p>
                                <p class="text-xs text-gray-400">Weka kuwa umelipwa</p>
                            </div>
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('payroll.index') }}" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group text-left">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-arrow-left text-gray-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Rudi</p>
                            <p class="text-xs text-gray-400">Orodha ya vikundi</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
async function submitProcess() {
    var confirmed = await showConfirmModal('Je, unataka kuchakata kipindi hiki? Mishahara itahesabiwa upya.', 'Chakata Kipindi');
    if (confirmed) document.getElementById('processForm').submit();
}

async function submitApprove() {
    var confirmed = await showConfirmModal('Je, unataka kuidhinisha kipindi hiki? Baada ya kuidhinisha, litaweza kulipwa.', 'Idhinisha Kipindi');
    if (confirmed) document.getElementById('approveForm').submit();
}

async function submitPay() {
    var confirmed = await showConfirmModal('Je, unataka kuweka alama ya malipo? Taarifa hii itahifadhiwa.', 'Weka Alama ya Malipo');
    if (confirmed) document.getElementById('payForm').submit();
}
</script>
@endsection
