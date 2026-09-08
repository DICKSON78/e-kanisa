@extends('layouts.app')

@section('title', $approval->title . ' - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('approvals.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi Orodhani">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-file-signature" style="color: #efc120"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $approval->title }}</h1>
                    <p class="text-sm text-gray-500">{{ $approval->approval_number }}</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($approval->canBeApprovedBy(auth()->user()) && $approval->status !== 'Imekataliwa' && $approval->status !== 'Imekamilika')
            <form action="{{ route('approvals.approve', $approval->id) }}" method="POST" id="approveForm" class="inline">
                @csrf
                <input type="hidden" name="signature_data" id="approveSignatureData" value="">
                <input type="hidden" name="comments" id="approveComments" value="">
                <input type="hidden" name="amount_approved" id="approveAmount" value="">
            </form>
            <button type="button" onclick="openApproveModal()" class="rx-btn rx-btn-primary flex items-center gap-2" id="approveBtn">
                <i class="fas fa-check"></i>
                <span class="hidden sm:inline">Idhini</span>
            </button>
            @endif
            @if($approval->canBeApprovedBy(auth()->user()) && $approval->status !== 'Imekataliwa' && $approval->status !== 'Imekamilika')
            <form action="{{ route('approvals.reject', $approval->id) }}" method="POST" id="rejectForm" class="inline">
                @csrf
                <input type="hidden" name="signature_data" id="rejectSignatureData" value="">
                <input type="hidden" name="rejection_reason" id="rejectReason" value="">
            </form>
            <button type="button" onclick="openRejectModal()" class="rx-btn rx-btn-danger flex items-center gap-2" id="rejectBtn">
                <i class="fas fa-times"></i>
                <span class="hidden sm:inline">Kataa</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Gradient Profile Banner -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)" class="p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15)">
                    <i class="fas fa-file-signature text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $approval->title }}</h2>
                            <div class="flex items-center gap-4 mt-2 flex-wrap">
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-hashtag"></i>
                                    <span>{{ $approval->approval_number }}</span>
                                </div>
                                @if($approval->status == 'Inasubiri')
                                    <span class="rx-badge text-xs" style="background: rgba(239,193,32,0.9); color: #360958;">
                                        <i class="fas fa-clock mr-1"></i>Inasubiri
                                    </span>
                                @elseif(in_array($approval->status, ['Mapitio ya Mhasibu', 'Imeidhinishwa na Mchungaji', 'Yakifuata Hatua']))
                                    <span class="rx-badge text-xs" style="background: rgba(59,130,246,0.9); color: white;">
                                        <i class="fas fa-spinner mr-1"></i>{{ $approval->status }}
                                    </span>
                                @elseif($approval->status == 'Imekamilika')
                                    <span class="rx-badge text-xs" style="background: rgba(34,197,94,0.9); color: white;">
                                        <i class="fas fa-check-circle mr-1"></i>Imekamilika
                                    </span>
                                @elseif($approval->status == 'Imekataliwa')
                                    <span class="rx-badge text-xs" style="background: rgba(239,68,68,0.9); color: white;">
                                        <i class="fas fa-times-circle mr-1"></i>Imekataliwa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info Bar -->
    <div class="rx-card rounded-2xl p-5">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Omamba</p>
                <p class="text-sm font-semibold text-gray-900">{{ $approval->requester->name ?? '-' }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Idara</p>
                <p class="text-sm font-semibold text-gray-900">{{ $approval->department->name ?? '-' }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Kiasi</p>
                <p class="text-sm font-bold" style="color: #360958">TZS {{ number_format($approval->amount_requested, 2) }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Prioriti</p>
                <p class="text-sm font-semibold text-gray-900">{{ $approval->priority }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Tarehe ya Ombi</p>
                <p class="text-sm font-semibold text-gray-900">{{ $approval->requested_date ? $approval->requested_date->format('d/m/Y') : '-' }}</p>
            </div>
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-1">Hali</p>
                @if($approval->status == 'Inasubiri')
                    <span class="rx-badge rx-badge-yellow text-[10px]"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                @elseif(in_array($approval->status, ['Mapitio ya Mhasibu', 'Imeidhinishwa na Mchungaji', 'Yakifuata Hatua']))
                    <span class="rx-badge rx-badge-blue text-[10px]"><i class="fas fa-spinner mr-1"></i>Yakifuata Hatua</span>
                @elseif($approval->status == 'Imekamilika')
                    <span class="rx-badge rx-badge-green text-[10px]"><i class="fas fa-check-circle mr-1"></i>Yaidhinishwa</span>
                @elseif($approval->status == 'Imekataliwa')
                    <span class="rx-badge rx-badge-red text-[10px]"><i class="fas fa-times-circle mr-1"></i>Yakataliwa</span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Maelezo -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo</h3>
                        <p class="text-xs text-gray-500">Maelezo kamili ya ombi la idhini</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-quote-left text-sm mt-1" style="color: #efc120"></i>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $approval->description ?: 'Hakuna maelezo yaliyotolewa.' }}</p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500 mb-1">Lengo la Matumizi</p>
                        <p class="text-sm font-medium text-gray-900">{{ $approval->expense_purpose }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-500 mb-1">Mtayarishaji</p>
                        <p class="text-sm font-medium text-gray-900">{{ $approval->creator->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Hatua za Idhini (Approval Steps Timeline) -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-project-diagram" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Hatua za Idhini</h3>
                        <p class="text-xs text-gray-500">Mchakato wa idhini hatua kwa hatua</p>
                    </div>
                </div>

                <div class="space-y-0">
                    @foreach($approval->steps->sortBy('level') as $step)
                    <div class="relative pl-8 pb-8 {{ $loop->last ? 'pb-0' : '' }}">
                        <!-- Timeline Line -->
                        @if(!$loop->last)
                        <div class="absolute left-3 top-8 bottom-0 w-0.5" style="background: {{ $step->acted_at ? ($step->decision == 'approved' ? '#16a34a' : '#ef4444') : '#e5e7eb' }}"></div>
                        @endif

                        <!-- Timeline Dot -->
                        <div class="absolute left-0 top-0 w-7 h-7 rounded-full flex items-center justify-center z-10" style="background: {{ $step->acted_at ? ($step->decision == 'approved' ? '#dcfce7' : '#fee2e2') : ($step->level == $approval->current_level && $approval->status !== 'Imekamilika' && $approval->status !== 'Imekataliwa' ? '#fef9c3' : '#f3f4f6') }}">
                            @if($step->acted_at)
                                @if($step->decision == 'approved')
                                    <i class="fas fa-check text-xs" style="color: #16a34a"></i>
                                @else
                                    <i class="fas fa-times text-xs" style="color: #ef4444"></i>
                                @endif
                            @elseif($step->level == $approval->current_level && $approval->status !== 'Imekamilika' && $approval->status !== 'Imekataliwa')
                                <i class="fas fa-clock text-xs" style="color: #ca8a04"></i>
                            @else
                                <i class="fas fa-minus text-xs text-gray-400"></i>
                            @endif
                        </div>

                        <!-- Step Content -->
                        <div class="bg-gray-50 rounded-xl p-4 {{ $step->level == $approval->current_level && $approval->status !== 'Imekamilika' && $approval->status !== 'Imekataliwa' ? 'border-2 border-yellow-200' : '' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold px-2 py-0.5 rounded" style="background: rgba(54,9,88,0.1); color: #360958;">Hatua {{ $step->level }}</span>
                                    <span class="rx-badge rx-badge-purple text-[10px]">{{ $step->role_required }}</span>
                                </div>
                                @if($step->acted_at)
                                    <span class="text-xs text-gray-500">{{ $step->acted_at->format('d/m/Y H:i') }}</span>
                                @elseif($step->level == $approval->current_level && $approval->status !== 'Imekamilika' && $approval->status !== 'Imekataliwa')
                                    <span class="text-xs font-semibold" style="color: #ca8a04">Inasubiri...</span>
                                @endif
                            </div>

                            @if($step->approver)
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c);">
                                    <span class="text-[10px] font-bold" style="color: #360958">{{ strtoupper(substr($step->approver->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm text-gray-700">{{ $step->approver->name }}</span>
                                @if($step->decision == 'approved')
                                    <span class="rx-badge rx-badge-green text-[10px]"><i class="fas fa-check mr-1"></i>Imeidhinishwa</span>
                                @elseif($step->decision == 'rejected')
                                    <span class="rx-badge rx-badge-red text-[10px]"><i class="fas fa-times mr-1"></i>Imekataliwa</span>
                                @endif
                            </div>
                            @endif

                            @if($step->comments)
                            <div class="mt-2 p-2 rounded-lg bg-white border border-gray-100">
                                <p class="text-xs text-gray-600"><i class="fas fa-comment-dots mr-1" style="color: #efc120"></i>{{ $step->comments }}</p>
                            </div>
                            @endif

                            @if($step->signature_path)
                            <div class="mt-2 flex items-center gap-2">
                                <i class="fas fa-pen-nib text-xs" style="color: #16a34a"></i>
                                <span class="text-xs text-gray-500">Saini ya Kidijitali:</span>
                                <img src="{{ asset('storage/' . $step->signature_path) }}" alt="Saini" class="h-8 rounded border border-gray-200 bg-white p-0.5">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Sidebar (1/3) -->
        <div class="space-y-6">
            <!-- Taarifa za Ombi -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Ombi</h3>
                        <p class="text-xs text-gray-500">Maelezo ya msingi</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Nambari</span>
                        <span class="text-sm font-mono font-semibold text-gray-900">{{ $approval->approval_number }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Idara</span>
                        <span class="rx-badge rx-badge-purple text-[10px]">{{ $approval->department->name ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Omamba</span>
                        <span class="text-sm font-medium text-gray-900">{{ $approval->requester->name ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Kipaumbele</span>
                        <span class="text-sm font-medium text-gray-900">{{ $approval->priority }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Kiasi Ombi</span>
                        <span class="text-sm font-bold" style="color: #360958">TZS {{ number_format($approval->amount_requested, 2) }}</span>
                    </div>
                    @if($approval->amount_approved)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Kiasi Idhini</span>
                        <span class="text-sm font-bold" style="color: #16a34a">TZS {{ number_format($approval->amount_approved, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Tarehe ya Ombi</span>
                        <span class="text-sm text-gray-900">{{ $approval->requested_date ? $approval->requested_date->format('d/m/Y') : '-' }}</span>
                    </div>
                    @if($approval->approved_date)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Tarehe ya Idhini</span>
                        <span class="text-sm text-gray-900">{{ $approval->approved_date->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-gray-500">Hali</span>
                        @if($approval->status == 'Inasubiri')
                            <span class="rx-badge rx-badge-yellow text-[10px]"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                        @elseif(in_array($approval->status, ['Mapitio ya Mhasibu', 'Imeidhinishwa na Mchungaji', 'Yakifuata Hatua']))
                            <span class="rx-badge rx-badge-blue text-[10px]"><i class="fas fa-spinner mr-1"></i>Yakifuata Hatua</span>
                        @elseif($approval->status == 'Imekamilika')
                            <span class="rx-badge rx-badge-green text-[10px]"><i class="fas fa-check-circle mr-1"></i>Yaidhinishwa</span>
                        @elseif($approval->status == 'Imekataliwa')
                            <span class="rx-badge rx-badge-red text-[10px]"><i class="fas fa-times-circle mr-1"></i>Yakataliwa</span>
                        @endif
                    </div>
                    @if($approval->rejection_reason)
                    <div class="mt-3 p-3 rounded-xl bg-red-50 border border-red-100">
                        <p class="text-xs font-semibold text-red-700 mb-1"><i class="fas fa-exclamation-triangle mr-1"></i>Sababu ya Kukataa:</p>
                        <p class="text-xs text-red-600">{{ $approval->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sahihi na Uthibitisho (Signature & Confirmation) -->
            @if(($approval->status !== 'Imekamilika' && $approval->status !== 'Imekataliwa') && $approval->canBeApprovedBy(auth()->user()))
            <div class="rx-card rounded-2xl p-6" id="approve">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-pen-nib" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Sahihi na Uthibitisho</h3>
                        <p class="text-xs text-gray-500">Weka sahihi na thibitisha uamuzi</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Signature Canvas -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Sahihi ya Kidijitali <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl overflow-hidden bg-white">
                            <canvas id="signatureCanvas" width="400" height="150" class="w-full cursor-crosshair" style="touch-action: none;"></canvas>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <button type="button" onclick="clearSignature()" class="rx-btn rx-btn-secondary text-xs flex items-center gap-1">
                                <i class="fas fa-eraser"></i> Futa Sahihi
                            </button>
                            <span id="signatureStatus" class="text-xs text-gray-400">Bado haijaandikwa</span>
                        </div>
                    </div>

                    <!-- OTP Verification -->
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-green-50 border border-green-100">
                        <input type="checkbox" id="otpVerified" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <label for="otpVerified" class="text-sm text-gray-700">
                            <span class="font-medium">Nathibitisha utambulisho wangu</span>
                            <span class="block text-xs text-gray-500">Sahihi hii ni ya mtu mwenyewe</span>
                        </label>
                    </div>

                    <!-- Comments -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maoni</label>
                        <textarea id="signatureComments" rows="3" class="rx-input rx-input-no-icon" placeholder="Weka maoni yako (si lazima)..."></textarea>
                    </div>

                    <!-- Amount Approved -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi Kilichoidhinishwa (TSh)</label>
                        <input type="number" id="signatureAmount" step="0.01" min="0" max="{{ $approval->amount_requested }}" value="{{ $approval->amount_requested }}" class="rx-input rx-input-no-icon">
                        <p class="mt-1 text-xs text-gray-500">Juu zaidi: TZS {{ number_format($approval->amount_requested, 2) }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="submitApproval('approve')" class="rx-btn rx-btn-primary flex-1 justify-center py-3" id="doApproveBtn">
                            <i class="fas fa-check"></i> Idhinisha
                        </button>
                        <button type="button" onclick="submitApproval('reject')" class="rx-btn rx-btn-danger flex-1 justify-center py-3" id="doRejectBtn">
                            <i class="fas fa-times"></i> Kataa
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Vikwazo vya Kiwango (Threshold) -->
            @php
                $threshold = \App\Models\ApprovalThreshold::findForAmount($approval->amount_requested);
            @endphp
            @if($threshold)
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-sliders-h" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Vikwazo vya Kiwango</h3>
                        <p class="text-xs text-gray-500">Kiwango kinachotumika kwa kiasi hiki</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Kiwango</span>
                        <span class="text-sm font-medium text-gray-900">TZS {{ number_format($threshold->min_amount, 2) }} - {{ $threshold->max_amount ? 'TZS ' . number_format($threshold->max_amount, 2) : 'Hakuna kikomo' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Muda Unaotarajiwa</span>
                        <span class="text-sm font-medium text-gray-900">{{ $threshold->expected_hours }} masaa</span>
                    </div>
                    <div class="py-2">
                        <span class="text-xs text-gray-500 block mb-2">Majukumu Yanayohitajika:</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($threshold->required_roles as $role)
                                <span class="rx-badge rx-badge-purple text-[10px]">{{ $role }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(22,163,74,0.1)">
                        <i class="fas fa-check-circle text-xl" style="color: #16a34a"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Idhinisha Ombi</h3>
                        <p class="text-sm text-gray-500">{{ $approval->title }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeApproveModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="rounded-xl p-4 border-l-4" style="background: rgba(22,163,74,0.05); border-left-color: #16a34a">
                <div class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-sm mt-0.5" style="color: #16a34a"></i>
                    <p class="text-sm text-gray-700">
                        Una uhakika unataka kuidhinisha ombi hili? Sahihi yako ya kidijitali itarekodwa.
                    </p>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi Kilichoidhinishwa (TSh)</label>
                <input type="number" id="modalApproveAmount" step="0.01" min="0" max="{{ $approval->amount_requested }}" value="{{ $approval->amount_requested }}" class="rx-input rx-input-no-icon text-lg font-bold" style="color: #16a34a">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maoni (Si lazima)</label>
                <textarea id="modalApproveComments" rows="3" class="rx-input rx-input-no-icon" placeholder="Andika maoni yako hapa..."></textarea>
            </div>
        </div>
        <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
            <button type="button" onclick="closeApproveModal()" class="rx-btn rx-btn-secondary">Funga</button>
            <button type="button" onclick="submitApproval('approve')" class="rx-btn flex items-center gap-2" style="background: #16a34a; color: white;">
                <i class="fas fa-check"></i>
                <span>Idhinisha</span>
            </button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-times-circle text-xl" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Kataa Ombi</h3>
                        <p class="text-sm text-gray-500">{{ $approval->title }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="rounded-xl p-4 border-l-4" style="background: rgba(239,68,68,0.05); border-left-color: #ef4444">
                <div class="flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle text-sm mt-0.5" style="color: #ef4444"></i>
                    <p class="text-sm text-gray-700">
                        Una uhakika unataka kukataa ombi hili? Hatua hii haiwezi kufutwa. Sahihi yako ya kidijitali itarekodwa.
                    </p>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Sababu ya Kukataa <span class="text-red-500">*</span></label>
                <textarea id="modalRejectReason" rows="4" required class="rx-input rx-input-no-icon" placeholder="Eleza sababu ya kukataa ombi hili..."></textarea>
            </div>
        </div>
        <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
            <button type="button" onclick="closeRejectModal()" class="rx-btn rx-btn-secondary">Funga</button>
            <button type="button" onclick="submitApproval('reject')" class="rx-btn rx-btn-danger flex items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Kataa Ombi</span>
            </button>
        </div>
    </div>
</div>

<script>
// Signature Canvas
var canvas = document.getElementById('signatureCanvas');
var ctx = canvas ? canvas.getContext('2d') : null;
var drawing = false;
var hasSignature = false;
var lastX = 0;
var lastY = 0;

function resizeCanvas() {
    if (!canvas) return;
    var rect = canvas.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = rect.height;
    ctx.strokeStyle = '#1f2937';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
}

if (canvas) {
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDraw);
    canvas.addEventListener('mouseleave', stopDraw);
    canvas.addEventListener('touchstart', startDrawTouch, { passive: false });
    canvas.addEventListener('touchmove', drawTouch, { passive: false });
    canvas.addEventListener('touchend', stopDraw);
}

function startDraw(e) {
    drawing = true;
    var rect = canvas.getBoundingClientRect();
    lastX = e.clientX - rect.left;
    lastY = e.clientY - rect.top;
}

function draw(e) {
    if (!drawing) return;
    var rect = canvas.getBoundingClientRect();
    var x = e.clientX - rect.left;
    var y = e.clientY - rect.top;
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    ctx.stroke();
    lastX = x;
    lastY = y;
    hasSignature = true;
    document.getElementById('signatureStatus').textContent = 'Sahihi imeandikwa';
    document.getElementById('signatureStatus').style.color = '#16a34a';
}

function startDrawTouch(e) {
    e.preventDefault();
    drawing = true;
    var rect = canvas.getBoundingClientRect();
    var touch = e.touches[0];
    lastX = touch.clientX - rect.left;
    lastY = touch.clientY - rect.top;
}

function drawTouch(e) {
    e.preventDefault();
    if (!drawing) return;
    var rect = canvas.getBoundingClientRect();
    var touch = e.touches[0];
    var x = touch.clientX - rect.left;
    var y = touch.clientY - rect.top;
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    ctx.stroke();
    lastX = x;
    lastY = y;
    hasSignature = true;
    document.getElementById('signatureStatus').textContent = 'Sahihi imeandikwa';
    document.getElementById('signatureStatus').style.color = '#16a34a';
}

function stopDraw() {
    drawing = false;
}

function clearSignature() {
    if (!canvas || !ctx) return;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    hasSignature = false;
    document.getElementById('signatureStatus').textContent = 'Bado haijaandikwa';
    document.getElementById('signatureStatus').style.color = '#9ca3af';
}

function signatureToBase64() {
    if (!canvas) return '';
    return canvas.toDataURL('image/png');
}

// Modal controls
function openApproveModal() {
    var modal = document.getElementById('approveModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() { modal.querySelector('div').classList.remove('scale-95'); }, 10);
    }
}

function closeApproveModal() {
    var modal = document.getElementById('approveModal');
    if (modal) {
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(function() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

function openRejectModal() {
    var modal = document.getElementById('rejectModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() { modal.querySelector('div').classList.remove('scale-95'); }, 10);
    }
}

function closeRejectModal() {
    var modal = document.getElementById('rejectModal');
    if (modal) {
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(function() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// Submit approval with signature
function submitApproval(type) {
    if (!hasSignature) {
        if (typeof showNotification === 'function') {
            showNotification('Tafadhali andika sahihi yako kwanza', 'warning', 'Onyo');
        }
        return;
    }

    var otpCheckbox = document.getElementById('otpVerified');
    if (otpCheckbox && !otpCheckbox.checked) {
        if (typeof showNotification === 'function') {
            showNotification('Tafadhali thibitisha utambulisho wako', 'warning', 'Onyo');
        }
        return;
    }

    var sigData = signatureToBase64();

    if (type === 'approve') {
        var modalAmount = document.getElementById('modalApproveAmount');
        var modalComments = document.getElementById('modalApproveComments');
        var amount = modalAmount ? modalAmount.value : document.getElementById('signatureAmount').value;
        var comments = modalComments ? modalComments.value : document.getElementById('signatureComments').value;

        document.getElementById('approveSignatureData').value = sigData;
        document.getElementById('approveComments').value = comments;
        document.getElementById('approveAmount').value = amount;
        closeApproveModal();
        document.getElementById('approveForm').submit();
    } else {
        var modalReason = document.getElementById('modalRejectReason');
        var reason = modalReason ? modalReason.value : '';

        if (!reason) {
            if (typeof showNotification === 'function') {
                showNotification('Tafadhali eleza sababu ya kukataa', 'warning', 'Onyo');
            }
            return;
        }

        document.getElementById('rejectSignatureData').value = sigData;
        document.getElementById('rejectReason').value = reason;
        closeRejectModal();
        document.getElementById('rejectForm').submit();
    }
}

// Close modals on overlay click
document.addEventListener('click', function(event) {
    if (event.target.id === 'approveModal') closeApproveModal();
    if (event.target.id === 'rejectModal') closeRejectModal();
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
    }
});
</script>
@endsection