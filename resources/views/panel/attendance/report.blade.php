@extends('layouts.app')
@section('title', 'Ripoti ya Uhudhuriaji - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('attendance.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-chart-bar" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ripoti ya Uhudhuriaji</h1>
                <p class="text-sm text-gray-500">Takwimu za uhudhuriaji kwa mwezi</p>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="rx-card rounded-xl p-4">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-filter text-xs" style="color: #efc120"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Chagua Kipindi</h3>
        </div>
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwaka</label>
                <select name="year" class="rx-select">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Mwezi</label>
                <select name="month" class="rx-select">
                    @php $months = [1=>'Januari',2=>'Februari',3=>'Machi',4=>'Aprili',5=>'Mei',6=>'Juni',7=>'Julai',8=>'Agosti',9=>'Septemba',10=>'Oktoba',11=>'Novemba',12=>'Desemba']; @endphp
                    @foreach($months as $num => $name)
                    <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-search"></i>
                <span>Onyesha</span>
            </button>
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Wanachama Wote</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMembers }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-users" style="color: #3b82f6"></i>
                </div>
            </div>
        </div>
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Wastani wa Uhudhuriaji</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($avgAttendance, 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-chart-line" style="color: #16a34a"></i>
                </div>
            </div>
        </div>
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Asilimia ya Uhudhuriaji</p>
                    <p class="text-2xl font-bold" style="color: #9333ea">{{ $attendanceRate }}%</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(147,51,234,0.1)">
                    <i class="fas fa-percentage" style="color: #9333ea"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-table text-xs" style="color: #efc120"></i>
            </div>
            <h3 class="text-base font-semibold text-gray-900">Uhudhuriaji kwa Wiki</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>Tarehe</th>
                        <th>Aina ya Huduma</th>
                        <th>Idadi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthlyAttendance as $date => $records)
                    @foreach($records as $record)
                    <tr>
                        <td class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($date)->format('d/m/Y (D)') }}</td>
                        <td class="text-sm text-gray-600">{{ $record->service_type }}</td>
                        <td class="text-sm font-bold text-gray-900">{{ $record->count }}</td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="rx-empty">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 mb-1">Hakuna Data</h3>
                                <p class="text-sm text-gray-500">Hakuna data ya uhudhuriaji kwa mwezi huu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
