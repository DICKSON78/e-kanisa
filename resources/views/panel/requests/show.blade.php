@extends('layouts.app')

@section('title', 'Taarifa za Ombi - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('requests.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-file-invoice-dollar" style="color: #efc120"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Taarifa za Ombi</h1>
                    <p class="text-sm text-gray-500">Angalia maelezo kamili ya ombi la fedha</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($request->status === 'Inasubiri')
            <a href="{{ route('requests.edit', $request->id) }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-edit"></i>
                <span class="hidden sm:inline">Hariri</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Gradient Profile Banner -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)" class="p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15)">
                    <i class="fas fa-file-invoice-dollar text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $request->title }}</h2>
                            <div class="flex items-center gap-4 mt-2 flex-wrap">
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-hashtag"></i>
                                    <span>{{ $request->request_number }}</span>
                                </div>
                                @if($request->status === 'Inasubiri')
                                    <span class="rx-badge text-xs" style="background: rgba(239,193,32,0.9); color: #360958;"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                                @elseif($request->status === 'Imeidhinishwa')
                                    <span class="rx-badge text-xs" style="background: rgba(34,197,94,0.9); color: white;"><i class="fas fa-check-circle mr-1"></i>Imeidhinishwa</span>
                                @else
                                    <span class="rx-badge text-xs" style="background: rgba(239,68,68,0.9); color: white;"><i class="fas fa-times-circle mr-1"></i>Imekataliwa</span>
                                @endif
                                @if($request->max_level > 0 && $request->status === 'Inasubiri')
                                <span class="text-xs opacity-75">Hatua {{ $request->current_level }} / {{ $request->max_level }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Timeline -->
    @if($request->max_level > 0 && count($approvalStages) > 0)
    <div class="rx-card rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-route" style="color: #efc120"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900">Mkurugenzo wa Idhinishaji</h3>
                <p class="text-xs text-gray-500">Hatua za idhinishaji kutoka chini hadi juu</p>
            </div>
        </div>

        <div class="relative">
            @foreach($approvalStages as $index => $stage)
            <div class="flex items-start gap-4 {{ !$loop->last ? 'pb-6' : '' }}">
                <div class="flex flex-col items-center">
                    @if($stage['status'] === 'approved')
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 z-10" style="background: rgba(22,163,74,0.1); border: 2px solid #16a34a;">
                            <i class="fas fa-check text-sm" style="color: #16a34a"></i>
                        </div>
                    @elseif($stage['status'] === 'rejected')
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 z-10" style="background: rgba(239,68,68,0.1); border: 2px solid #ef4444;">
                            <i class="fas fa-times text-sm" style="color: #ef4444"></i>
                        </div>
                    @elseif($stage['status'] === 'pending')
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 z-10 animate-pulse" style="background: rgba(239,193,32,0.15); border: 2px solid #efc120;">
                            <i class="fas fa-clock text-sm" style="color: #d4a81c"></i>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 z-10" style="background: #f3f4f6; border: 2px solid #d1d5db;">
                            <i class="fas fa-lock text-sm text-gray-400"></i>
                        </div>
                    @endif
                    @if(!$loop->last)
                        @if($stage['status'] === 'approved')
                        <div class="w-0.5 flex-1 mt-1" style="background: #16a34a; min-height: 2rem;"></div>
                        @else
                        <div class="w-0.5 flex-1 mt-1 bg-gray-200" style="min-height: 2rem;"></div>
                        @endif
                    @endif
                </div>

                <div class="flex-1 pt-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-semibold uppercase tracking-wide px-2 py-0.5 rounded-full {{ $stage['status'] === 'approved' ? 'text-green-700' : ($stage['status'] === 'rejected' ? 'text-red-700' : ($stage['status'] === 'pending' ? 'text-yellow-700' : 'text-gray-500')) }}" style="background: {{ $stage['status'] === 'approved' ? 'rgba(22,163,74,0.1)' : ($stage['status'] === 'rejected' ? 'rgba(239,68,68,0.1)' : ($stage['status'] === 'pending' ? 'rgba(239,193,32,0.15)' : '#f3f4f6')) }}">
                            Hatua ya {{ $stage['level'] }}
                        </span>
                        <span class="text-sm font-semibold text-gray-900">{{ $stage['role'] }}</span>
                        @if($stage['status'] === 'approved')
                            <span class="rx-badge rx-badge-green text-[10px]">Imekubaliwa</span>
                        @elseif($stage['status'] === 'rejected')
                            <span class="rx-badge rx-badge-red text-[10px]">Imekataliwa</span>
                        @elseif($stage['status'] === 'pending')
                            <span class="rx-badge rx-badge-yellow text-[10px]">Inasubiri Saahihi</span>
                        @else
                            <span class="rx-badge rx-badge-gray text-[10px]">Inasubiri</span>
                        @endif
                    </div>
                    @if($stage['approver'])
                    <div class="mt-2 text-xs text-gray-600">
                        <i class="fas fa-user mr-1 text-gray-400"></i>{{ $stage['approver'] }}
                        @if($stage['date'])
                        <span class="mx-1">&middot;</span>
                        <i class="fas fa-calendar mr-1 text-gray-400"></i>{{ \Carbon\Carbon::parse($stage['date'])->format('d/m/Y H:i') }}
                        @endif
                    </div>
                    @endif
                    @if($stage['comments'])
                    <div class="mt-2 text-xs text-gray-500 bg-gray-50 rounded-lg p-2.5">
                        <i class="fas fa-comment-dots mr-1 text-gray-400"></i>{{ $stage['comments'] }}
                    </div>
                    @endif
                    @if($stage['signature'])
                    <div class="mt-3 p-3 rounded-xl border border-gray-200 bg-white">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-pen-nib text-xs" style="color: #360958"></i>
                            <span class="text-xs font-semibold text-gray-700">Sahihi ya Kidigitali</span>
                        </div>
                        <img src="{{ $stage['signature'] }}" alt="Sahihi ya {{ $stage['role'] }}" class="max-h-16 rounded-lg border border-gray-100 bg-gray-50 px-2 py-1">
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Taarifa za Ombi -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Ombi</h3>
                        <p class="text-xs text-gray-500">Maelezo ya ombi la fedha</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Idara</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $request->department }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Tarehe ya Kuomba</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $request->requested_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Ameomba</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $request->requester->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Hali</p>
                        <div class="flex items-center gap-2">
                            @if($request->status === 'Inasubiri')
                                <span class="rx-badge rx-badge-yellow text-xs"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                            @elseif($request->status === 'Imeidhinishwa')
                                <span class="rx-badge rx-badge-green text-xs"><i class="fas fa-check-circle mr-1"></i>Imeidhinishwa</span>
                            @else
                                <span class="rx-badge rx-badge-red text-xs"><i class="fas fa-times-circle mr-1"></i>Imekataliwa</span>
                            @endif
                        </div>
                    </div>
                    @if($request->approved_by && $request->status !== 'Inasubiri' && $request->approved_date)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">{{ $request->status === 'Imeidhinishwa' ? 'Ameidhinisha' : 'Amekataa' }}</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-check text-sm" style="color: {{ $request->status === 'Imeidhinishwa' ? '#16a34a' : '#ef4444' }}"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $request->approver->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Tarehe ya Uamuzi</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-check text-sm" style="color: {{ $request->status === 'Imeidhinishwa' ? '#16a34a' : '#ef4444' }}"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $request->approved_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maelezo -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo ya Ombi</h3>
                        <p class="text-xs text-gray-500">Maelezo kamili kuhusu ombi hili</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-quote-left text-sm mt-1" style="color: #efc120"></i>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $request->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Maoni ya Uamuzi -->
            @if($request->approval_notes && $request->status !== 'Inasubiri')
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba({{ $request->status === 'Imekataliwa' ? '239,68,68' : '59,130,246' }},0.1)">
                        <i class="fas fa-comment-dots" style="color: {{ $request->status === 'Imekataliwa' ? '#ef4444' : '#3b82f6' }}"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maoni ya Uamuzi</h3>
                        <p class="text-xs text-gray-500">Maoni kutoka kwa msimamizi</p>
                    </div>
                </div>
                <div class="rounded-xl p-4 border" style="background: {{ $request->status === 'Imekataliwa' ? 'rgba(239,68,68,0.05)' : 'rgba(59,130,246,0.05)' }}; border-color: {{ $request->status === 'Imekataliwa' ? 'rgba(239,68,68,0.2)' : 'rgba(59,130,246,0.2)' }}">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle text-sm mt-1" style="color: {{ $request->status === 'Imekataliwa' ? '#ef4444' : '#3b82f6' }}"></i>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $request->approval_notes }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Fedha -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-money-bill-wave" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Fedha</h3>
                        <p class="text-xs text-gray-500">Kiasi kilichoombwa na kuidhinishwa</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="rounded-xl p-4 border-2" style="background: rgba(239,193,32,0.05); border-color: rgba(239,193,32,0.2)">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-hand-holding-usd text-sm" style="color: #efc120"></i>
                            <span class="text-xs font-medium text-gray-700">Kiasi Kilichoombwa</span>
                        </div>
                        <p class="text-xl font-bold" style="color: #360958">TZS {{ number_format($request->amount_requested, 2) }}</p>
                    </div>
                    @if($request->amount_approved)
                    <div class="rounded-xl p-4 border-2" style="background: rgba(22,163,74,0.05); border-color: rgba(22,163,74,0.2)">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-check-circle text-sm" style="color: #16a34a"></i>
                            <span class="text-xs font-medium text-gray-700">Kiasi Kilichoidhinishwa</span>
                        </div>
                        <p class="text-xl font-bold" style="color: #16a34a">TZS {{ number_format($request->amount_approved, 2) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Vitendo -->
            @php
                $currentUser = auth()->user();
                $userRole = $currentUser->role->name ?? '';
                $nextStep = $request->status === 'Inasubiri' ? $request->nextPendingStep() : null;
                $canAct = $nextStep && $userRole === $nextStep->role_required;
            @endphp

            @if($request->status === 'Inasubiri' && $canAct)
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-tasks" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Vitendo</h3>
                        <p class="text-xs text-gray-500">Chagua kitendo kwa ombi hili</p>
                    </div>
                </div>
                @if($nextStep)
                <div class="mb-4 p-3 rounded-xl" style="background: rgba(239,193,32,0.08)">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-arrow-right text-xs" style="color: #efc120"></i>
                        <span class="text-xs font-medium text-gray-700">
                            Hatua ya sasa: <strong>{{ $nextStep->role_required }}</strong> (Hatua {{ $nextStep->level }}/{{ $request->max_level }})
                        </span>
                    </div>
                </div>
                @endif
                <div class="space-y-3">
                    <button onclick="openModal('approveModal')" class="rx-btn rx-btn-primary w-full justify-center py-3 flex items-center gap-2" style="background: #16a34a; color: white;">
                        <i class="fas fa-pen-nib"></i>
                        <span>Sahihi na Idhinisha</span>
                    </button>
                    <button onclick="openModal('rejectModal')" class="rx-btn w-full justify-center py-3 flex items-center gap-2" style="background: #ef4444; color: white;">
                        <i class="fas fa-times"></i>
                        <span>Kataa Ombi</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal with Digital Signature -->
@if($request->status === 'Inasubiri')
<div id="approveModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(22,163,74,0.1)">
                        <i class="fas fa-pen-nib text-xl" style="color: #16a34a"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Sahihi na Idhinisha</h3>
                        <p class="text-sm text-gray-500">{{ $request->title }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('approveModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form action="{{ route('requests.approve', $request->id) }}" method="POST" id="approveForm" onsubmit="return captureSignature(event)">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi Kilichoidhinishwa <span class="text-red-500">*</span></label>
                    <input type="number" name="amount_approved" id="amount_approved" step="0.01" min="0" max="{{ $request->amount_requested }}" value="{{ old('amount_approved', $request->amount_requested) }}" required class="rx-input rx-input-no-icon text-lg font-bold" style="color: #16a34a">
                    <p class="mt-1 text-xs text-gray-500">Juu zaidi: TZS {{ number_format($request->amount_requested, 2) }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maoni (Si lazima)</label>
                    <textarea name="approval_notes" rows="2" class="rx-input rx-input-no-icon" placeholder="Andika maoni yako hapa...">{{ old('approval_notes') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                        Sahihi ya Kidigitali <span class="text-red-500">*</span>
                    </label>
                    <div class="relative border-2 border-dashed rounded-xl overflow-hidden" style="border-color: #360958;" id="signatureBorder">
                        <canvas id="signatureCanvas" width="500" height="180" class="w-full cursor-crosshair bg-white"></canvas>
                        <div id="signaturePlaceholder" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <i class="fas fa-pen-nib text-gray-300 text-2xl mb-2"></i>
                            <p class="text-xs text-gray-400">Chora sahihi yako hapa</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <button type="button" onclick="clearSignature()" class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1">
                            <i class="fas fa-eraser"></i> Futa Sahihi
                        </button>
                    </div>
                    <input type="hidden" name="signature_data" id="signatureData">
                    <input type="hidden" name="digital_signature" id="digitalSignature">
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeModal('approveModal')" class="rx-btn rx-btn-secondary">Funga</button>
                <button type="submit" class="rx-btn flex items-center gap-2" style="background: #16a34a; color: white;" id="approveSubmitBtn">
                    <i class="fas fa-pen-nib"></i>
                    <span>Sahihi na Idhinisha</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-times-circle text-xl" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Kataa Ombi</h3>
                        <p class="text-sm text-gray-500">{{ $request->title }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('rejectModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form action="{{ route('requests.reject', $request->id) }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div class="rounded-xl p-4 border-l-4" style="background: rgba(202,138,4,0.05); border-left-color: #ca8a04">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle text-sm mt-0.5" style="color: #ca8a04"></i>
                        <p class="text-sm text-gray-700">Una uhakika unataka kukataa ombi hili? Hatua hii haiwezi kufutwa.</p>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Sababu ya Kukataa <span class="text-red-500">*</span></label>
                    <textarea name="approval_notes" rows="4" required class="rx-input rx-input-no-icon" placeholder="Eleza sababu ya kukataa ombi hili...">{{ old('approval_notes') }}</textarea>
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeModal('rejectModal')" class="rx-btn rx-btn-secondary">Funga</button>
                <button type="submit" class="rx-btn rx-btn-danger flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Kataa Ombi</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() {
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
        if (modalId === 'approveModal') initSignatureCanvas();
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(function() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 200);
    }
}

document.querySelectorAll('[id$="Modal"]').forEach(function(modal) {
    modal.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
});
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('[id$="Modal"]:not(.hidden)').forEach(function(modal) { closeModal(modal.id); });
    }
});

var signatureCanvas, signatureCtx;
var isDrawing = false;
var hasSignature = false;
var lastX, lastY;

function initSignatureCanvas() {
    signatureCanvas = document.getElementById('signatureCanvas');
    if (!signatureCanvas) return;
    signatureCtx = signatureCanvas.getContext('2d');
    var rect = signatureCanvas.parentElement.getBoundingClientRect();
    signatureCanvas.width = rect.width;
    signatureCanvas.height = 180;
    signatureCtx.strokeStyle = '#360958';
    signatureCtx.lineWidth = 2.5;
    signatureCtx.lineCap = 'round';
    signatureCtx.lineJoin = 'round';
    signatureCanvas.addEventListener('mousedown', startDrawing);
    signatureCanvas.addEventListener('mousemove', draw);
    signatureCanvas.addEventListener('mouseup', stopDrawing);
    signatureCanvas.addEventListener('mouseleave', stopDrawing);
    signatureCanvas.addEventListener('touchstart', handleTouchStart, { passive: false });
    signatureCanvas.addEventListener('touchmove', handleTouchMove, { passive: false });
    signatureCanvas.addEventListener('touchend', stopDrawing);
}

function startDrawing(e) {
    isDrawing = true;
    hasSignature = true;
    var placeholder = document.getElementById('signaturePlaceholder');
    if (placeholder) placeholder.style.display = 'none';
    var rect = signatureCanvas.getBoundingClientRect();
    lastX = (e.clientX - rect.left) * (signatureCanvas.width / rect.width);
    lastY = (e.clientY - rect.top) * (signatureCanvas.height / rect.height);
    signatureCtx.beginPath();
    signatureCtx.moveTo(lastX, lastY);
}

function draw(e) {
    if (!isDrawing) return;
    var rect = signatureCanvas.getBoundingClientRect();
    var x = (e.clientX - rect.left) * (signatureCanvas.width / rect.width);
    var y = (e.clientY - rect.top) * (signatureCanvas.height / rect.height);
    signatureCtx.lineTo(x, y);
    signatureCtx.stroke();
    signatureCtx.beginPath();
    signatureCtx.moveTo(x, y);
}

function stopDrawing() { isDrawing = false; }

function handleTouchStart(e) {
    e.preventDefault();
    var touch = e.touches[0];
    signatureCanvas.dispatchEvent(new MouseEvent('mousedown', { clientX: touch.clientX, clientY: touch.clientY }));
}
function handleTouchMove(e) {
    e.preventDefault();
    var touch = e.touches[0];
    signatureCanvas.dispatchEvent(new MouseEvent('mousemove', { clientX: touch.clientX, clientY: touch.clientY }));
}

function clearSignature() {
    if (signatureCtx && signatureCanvas) {
        signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
        hasSignature = false;
        var placeholder = document.getElementById('signaturePlaceholder');
        if (placeholder) placeholder.style.display = 'flex';
    }
}

function captureSignature(e) {
    if (!hasSignature) {
        e.preventDefault();
        alert('Tafadhali sahihi kidigitali kabla ya kuendelea.');
        return false;
    }
    document.getElementById('signatureData').value = signatureCanvas.toDataURL('image/png');
    document.getElementById('digitalSignature').value = 'signed';
    return true;
}

function showFlashNotification(message, type) {
    var notification = document.createElement('div');
    var colors = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-times-circle';
    notification.className = 'fixed top-4 right-4 z-[10001] px-5 py-3 rounded-xl border shadow-lg flex items-center gap-2 ' + colors;
    notification.innerHTML = '<i class="fas ' + icon + '"></i> <span class="text-sm font-medium">' + message + '</span>';
    document.body.appendChild(notification);
    setTimeout(function() {
        notification.style.transition = 'opacity 0.3s';
        notification.style.opacity = '0';
        setTimeout(function() { notification.remove(); }, 300);
    }, 4000);
}

@if(session('success'))
showFlashNotification('{{ session('success') }}', 'success');
@endif
@if(session('error'))
showFlashNotification('{{ session('error') }}', 'error');
@endif
</script>
@endsection
