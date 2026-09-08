@extends('layouts.app')

@section('title', 'Maelezo ya Uhamisho - Mfumo wa ROC')
@section('page-title', 'Maelezo ya Uhamisho')
@section('page-subtitle', 'Angalia maelezo kamili za uhamisho')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-exchange-alt text-sm" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Maelezo ya Uhamisho</h1>
                <p class="text-sm text-gray-500">Taarifa kamili za uhamisho wa muumini</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            @if($transfer->status == 'Inasubiri' && (Auth::user()->isMchungaji() || Auth::user()->isMhasibu()))
            <button onclick="confirmAction('approve', {{ $transfer->id }}, '{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->last_name ?? '' }}')"
                    class="rx-btn flex items-center gap-2 text-sm font-semibold shadow-sm hover:shadow-md transition-all" style="background: linear-gradient(135deg, #16a34a, #15803d); color: white; border-radius: 0.75rem; padding: 0.5rem 1rem;">
                <i class="fas fa-check"></i>
                <span class="hidden sm:inline">Idhinisha</span>
            </button>
            <button onclick="confirmAction('reject', {{ $transfer->id }}, '{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->last_name ?? '' }}')"
                    class="rx-btn flex items-center gap-2 text-sm font-semibold shadow-sm hover:shadow-md transition-all" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; border-radius: 0.75rem; padding: 0.5rem 1rem;">
                <i class="fas fa-times"></i>
                <span class="hidden sm:inline">Kataa</span>
            </button>

            <!-- Hidden Forms -->
            <form id="approve-form-{{ $transfer->id }}" action="{{ route('transfers.approve', $transfer->id) }}" method="POST" class="hidden">
                @csrf
            </form>
            <form id="reject-form-{{ $transfer->id }}" action="{{ route('transfers.reject', $transfer->id) }}" method="POST" class="hidden">
                @csrf
            </form>
            @endif
            <a href="{{ route('transfers.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Rudi Orodhani</span>
            </a>
        </div>
    </div>

    <!-- Transfer Status Banner -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%)" class="p-8">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.1)">
                    <i class="fas fa-exchange-alt text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->last_name ?? '' }}</h2>
                            <div class="flex items-center gap-3 mt-2">
                                @if($transfer->transfer_type == 'Kuingia')
                                    <span class="inline-flex items-center px-3 py-1 bg-green-500 bg-opacity-80 text-white rounded-full text-sm font-semibold">
                                        <i class="fas fa-sign-in-alt mr-1.5"></i>Kuingia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-orange-500 bg-opacity-80 text-white rounded-full text-sm font-semibold">
                                        <i class="fas fa-sign-out-alt mr-1.5"></i>Kutoka
                                    </span>
                                @endif

                                @if($transfer->status == 'Inasubiri')
                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-500 bg-opacity-80 text-white rounded-full text-sm font-semibold">
                                        <i class="fas fa-clock mr-1.5"></i>Inasubiri
                                    </span>
                                @elseif($transfer->status == 'Imeidhinishwa')
                                    <span class="inline-flex items-center px-3 py-1 bg-green-500 bg-opacity-80 text-white rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1.5"></i>Imeidhinishwa
                                    </span>
                                @elseif($transfer->status == 'Imekataliwa')
                                    <span class="inline-flex items-center px-3 py-1 bg-red-500 bg-opacity-80 text-white rounded-full text-sm font-semibold">
                                        <i class="fas fa-times-circle mr-1.5"></i>Imekataliwa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Member Information Card -->
        <div class="rx-card rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-user text-sm" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Taarifa za Muumini</h3>
                    <p class="text-sm text-gray-500">Taarifa za msingi za muumini</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Jina Kamili</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->member->first_name ?? '' }} {{ $transfer->member->middle_name ?? '' }} {{ $transfer->member->last_name ?? '' }}</p>
                    </div>
                </div>

                @if($transfer->member?->member_number)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Namba ya Muumini</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-hashtag text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900 font-mono">{{ $transfer->member->member_number }}</p>
                    </div>
                </div>
                @endif

                @if($transfer->member?->phone)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Namba ya Simu</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->member->phone }}</p>
                    </div>
                </div>
                @endif

                @if($transfer->member?->email)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Barua pepe</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->member->email }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Transfer Details Card -->
        <div class="rx-card rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-exchange-alt text-sm" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Maelezo ya Uhamisho</h3>
                    <p class="text-sm text-gray-500">Taarifa kamili za uhamisho</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Aina ya Uhamisho</p>
                    <div class="flex items-center gap-2">
                        @if($transfer->transfer_type == 'Kuingia')
                            <i class="fas fa-sign-in-alt text-green-500 text-xs"></i>
                            <p class="text-sm font-medium text-green-700">Kuingia (Transfer In)</p>
                        @else
                            <i class="fas fa-sign-out-alt text-orange-500 text-xs"></i>
                            <p class="text-sm font-medium text-orange-700">Kutoka (Transfer Out)</p>
                        @endif
                    </div>
                </div>

                @if($transfer->from_church)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Kanisa la Kutoka</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-church text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->from_church }}</p>
                    </div>
                </div>
                @endif

                @if($transfer->to_church)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Kanisa la Kwenda</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-church text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->to_church }}</p>
                    </div>
                </div>
                @endif

                @if($transfer->from_pastor)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Mchungaji wa Kuondoka</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-tie text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->from_pastor }}</p>
                    </div>
                </div>
                @endif

                @if($transfer->to_pastor)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Mchungaji wa Kupokea</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-tie text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->to_pastor }}</p>
                    </div>
                </div>
                @endif

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Tarehe ya Uhamisho</p>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($transfer->reason)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Sababu</p>
                    <div class="flex items-start gap-2">
                        <i class="fas fa-question-circle text-gray-400 text-xs mt-0.5"></i>
                        <p class="text-sm font-medium text-gray-900">{{ $transfer->reason }}</p>
                    </div>
                </div>
                @endif

                @if($transfer->notes)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Maelezo</p>
                    <div class="flex items-start gap-2">
                        <i class="fas fa-sticky-note text-gray-400 text-xs mt-0.5"></i>
                        <p class="text-sm text-gray-900">{{ $transfer->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Confirm Action Modal -->
<div id="confirmActionModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="confirmActionModalContent">
        <div class="p-6 text-center">
            <div id="confirmActionIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="confirmActionIconClass" class="text-3xl"></i>
            </div>
            <h3 id="confirmActionTitle" class="text-xl font-bold text-gray-900 mb-2">Thibitisha</h3>
            <p id="confirmActionMessage" class="text-gray-500 text-sm mb-2">Je, una uhakika?</p>
            <p id="confirmActionName" class="text-lg font-semibold mb-6"></p>
            <div class="flex gap-3">
                <button onclick="closeConfirmActionModal()" class="rx-btn rx-btn-secondary flex-1">
                    <i class="fas fa-xmark mr-1"></i> Ghairi
                </button>
                <button id="confirmActionBtn" class="rx-btn flex-1 text-sm font-medium text-white rounded-xl transition-all flex items-center justify-center gap-2">
                    <i id="confirmActionBtnIcon" class="fas fa-check"></i>
                    <span id="confirmActionBtnText">Thibitisha</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Modal -->
<div id="transferAlertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="transferAlertModalContent">
        <div class="p-6 text-center">
            <div id="transferAlertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="transferAlertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="transferAlertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="transferAlertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeTransferAlertModal()" class="rx-btn rx-btn-primary w-full">
                <i class="fas fa-check mr-1"></i> Sawa, Nimeelewa
            </button>
        </div>
    </div>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
let currentAction = null;
let currentTransferId = null;

function confirmAction(action, transferId, transferName) {
    currentAction = action;
    currentTransferId = transferId;

    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');
    const iconContainer = document.getElementById('confirmActionIcon');
    const iconClass = document.getElementById('confirmActionIconClass');
    const title = document.getElementById('confirmActionTitle');
    const message = document.getElementById('confirmActionMessage');
    const nameEl = document.getElementById('confirmActionName');
    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    if (action === 'approve') {
        iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100';
        iconClass.className = 'fas fa-check-circle text-3xl text-green-600';
        title.textContent = 'Thibitisha Uhamisho';
        message.textContent = 'Je, una uhakika unataka kuidhinisha uhamisho huu?';
        nameEl.textContent = transferName;
        nameEl.className = 'text-lg font-semibold mb-6 text-green-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700';
        btnIcon.className = 'fas fa-check';
        btnText.textContent = 'Idhinisha';
    } else if (action === 'reject') {
        iconContainer.className = 'h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100';
        iconClass.className = 'fas fa-times-circle text-3xl text-red-600';
        title.textContent = 'Kataa Uhamisho';
        message.textContent = 'Je, una uhakika unataka kukataa uhamisho huu?';
        nameEl.textContent = transferName;
        nameEl.className = 'text-lg font-semibold mb-6 text-red-600';
        btn.className = 'flex-1 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700';
        btnIcon.className = 'fas fa-times';
        btnText.textContent = 'Kataa';
    }

    btn.onclick = executeAction;
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeConfirmActionModal() {
    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        currentAction = null;
        currentTransferId = null;
    }, 200);
}

function executeAction() {
    if (!currentAction || !currentTransferId) return;

    const btn = document.getElementById('confirmActionBtn');
    const btnIcon = document.getElementById('confirmActionBtnIcon');
    const btnText = document.getElementById('confirmActionBtnText');

    btn.disabled = true;
    btnIcon.className = 'fas fa-spinner fa-spin';
    btnText.textContent = 'Inatuma...';

    const formId = `${currentAction}-form-${currentTransferId}`;
    const form = document.getElementById(formId);

    if (form) {
        const formData = new FormData(form);
        const csrf = form.querySelector('input[name="_token"]')?.value;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {})
            },
            body: formData
        })
        .then(async (res) => {
            const contentType = res.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw data;
                return data;
            } else {
                if (!res.ok) throw new Error('Hitilafu imetokea');
                return { success: true, message: 'Imefanikiwa' };
            }
        })
        .then((data) => {
            showTransferAlert('success', 'Imefanikiwa', data.message || 'Imefanikiwa');
            closeConfirmActionModal();
            setTimeout(() => window.location.reload(), 1500);
        })
        .catch((err) => {
            const msg = err?.message || 'Hitilafu imetokea. Tafadhali jaribu tena.';
            showTransferAlert('error', 'Hitilafu', msg);
        })
        .finally(() => {
            btn.disabled = false;
            btnIcon.className = 'fas fa-check';
            btnText.textContent = 'Thibitisha';
        });
    } else {
        showTransferAlert('error', 'Hitilafu', 'Fomu haijapatikana. Tafadhali jaribu tena.');
        closeConfirmActionModal();
    }
}

function showTransferAlert(type, title, message) {
    const modal = document.getElementById('transferAlertModal');
    const content = document.getElementById('transferAlertModalContent');
    const iconContainer = document.getElementById('transferAlertIcon');
    const iconClass = document.getElementById('transferAlertIconClass');
    const titleEl = document.getElementById('transferAlertTitle');
    const messageEl = document.getElementById('transferAlertMessage');

    if (!modal) {
        alert(title + ': ' + message);
        return;
    }

    const configs = {
        'success': { bgColor: 'bg-green-100', iconColor: 'text-green-600', icon: 'fas fa-check-circle' },
        'error': { bgColor: 'bg-red-100', iconColor: 'text-red-600', icon: 'fas fa-times-circle' },
        'warning': { bgColor: 'bg-yellow-100', iconColor: 'text-yellow-600', icon: 'fas fa-exclamation-triangle' },
        'info': { bgColor: 'bg-blue-100', iconColor: 'text-blue-600', icon: 'fas fa-info-circle' }
    };

    const config = configs[type] || configs['info'];
    iconContainer.className = `h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4 ${config.bgColor}`;
    iconClass.className = `${config.icon} text-3xl ${config.iconColor}`;
    titleEl.textContent = title;
    messageEl.textContent = message;

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeTransferAlertModal() {
    const modal = document.getElementById('transferAlertModal');
    const content = document.getElementById('transferAlertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// Close modals on backdrop click
document.getElementById('confirmActionModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmActionModal();
});
document.getElementById('transferAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeTransferAlertModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeConfirmActionModal();
        closeTransferAlertModal();
    }
});

// Show flash messages
@if(session('success'))
showTransferAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif

@if(session('error'))
showTransferAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif

@if(session('warning'))
showTransferAlert('warning', 'Onyo!', '{{ session('warning') }}');
@endif
</script>
@endsection
