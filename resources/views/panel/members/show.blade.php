@extends('layouts.app')

@section('title', 'Taarifa za Muumini - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('members.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-user" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Taarifa za Muumini</h1>
            <p class="text-sm text-gray-500">Angalia taarifa kamili za muumini</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('members.edit', $member->id) }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-edit"></i> Hariri
            </a>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8" style="background: linear-gradient(135deg, #360958 0%, #2a0745 50%, #1f0533 100%);">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Avatar -->
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold flex-shrink-0" style="background: linear-gradient(135deg, #efc120, #d4a81c); color: #360958;">
                    {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                </div>
                <!-- Info -->
                <div class="flex-1 text-white min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold truncate">{{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}</h2>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 text-sm text-white/80">
                                    <i class="fas fa-hashtag text-xs"></i> {{ $member->member_number }}
                                </span>
                                @if($member->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(34,197,94,0.2); color: #4ade80;">
                                        <i class="fas fa-check-circle"></i> Hai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(239,68,68,0.2); color: #f87171;">
                                        <i class="fas fa-times-circle"></i> Haihitajiki
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button onclick="viewQrCode('{{ $member->id }}', '{{ $member->member_number }}')"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200" style="background: rgba(255,255,255,0.15); color: white; backdrop-filter: blur(4px);">
                            <i class="fas fa-qrcode"></i> QR Code
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Bar -->
        <div class="px-6 md:px-8 py-4 border-b border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-phone text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Simu</p>
                    <p class="text-sm font-medium text-gray-900">{{ $member->phone }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-venus-mars text-purple-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Jinsia</p>
                    <p class="text-sm font-medium text-gray-900">{{ $member->gender == 'Mme' ? 'Mwanaume' : 'Mwanamke' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar text-emerald-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Uanachama</p>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->membership_date)->format('d M Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-heart text-amber-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Hali ya Ndoa</p>
                    <p class="text-sm font-medium text-gray-900">{{ $member->marital_status }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa za Kibinafsi</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1">
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-birthday-cake w-4 text-center text-gray-400"></i> Tarehe ya Kuzaliwa</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar-alt w-4 text-center text-gray-400"></i> Umri</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->date_of_birth)->age }} miaka</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2">
                                <i class="fas fa-{{ $member->gender == 'Mme' ? 'male' : 'female' }} w-4 text-center text-gray-400"></i> Jinsia
                            </span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->gender == 'Mme' ? 'Mwanaume' : 'Mwanamke' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-heart w-4 text-center text-gray-400"></i> Hali ya Ndoa</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->marital_status }}</span>
                        </div>
                        @if($member->id_number)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-id-card w-4 text-center text-gray-400"></i> Namba ya Kitambulisho</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->id_number }}</span>
                        </div>
                        @endif
                        @if($member->occupation)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-briefcase w-4 text-center text-gray-400"></i> Kazi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->occupation }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-phone-alt text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa za Mawasiliano</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1">
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-mobile-alt w-4 text-center text-gray-400"></i> Simu</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->phone }}</span>
                        </div>
                        @if($member->email)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-envelope w-4 text-center text-gray-400"></i> Barua Pepe</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->email }}</span>
                        </div>
                        @endif
                        @if($member->address)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-map-marker-alt w-4 text-center text-gray-400"></i> Anwani</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->address }}</span>
                        </div>
                        @endif
                        @if($member->city || $member->region)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-city w-4 text-center text-gray-400"></i> Jiji/Mkoa</span>
                            <span class="text-sm font-medium text-gray-900">{{ $member->city }}{{ $member->city && $member->region ? ', ' : '' }}{{ $member->region }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Church Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-church text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Taarifa za Kikristo</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1">
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar-check w-4 text-center text-gray-400"></i> Tarehe ya Ujumbe</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->membership_date)->format('d/m/Y') }}</span>
                        </div>
                        @if($member->baptism_date)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-water w-4 text-center text-gray-400"></i> Tarehe ya Ubatizo</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->baptism_date)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        @if($member->confirmation_date)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-hands-praying w-4 text-center text-gray-400"></i> Uthibitisho</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->confirmation_date)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($member->notes)
            <!-- Notes -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-sticky-note text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Maelezo Mengine</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $member->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Contribution Summary -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-hand-holding-usd text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Michango</h3>
                </div>
                <div class="p-6">
                    @if(isset($contributionSummary) && count($contributionSummary) > 0)
                        <div class="space-y-3">
                            @foreach($contributionSummary as $summary)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">{{ $summary->category_name }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($summary->total, 0) }} TZS</span>
                            </div>
                            @endforeach
                            <div class="flex items-center justify-between pt-3 mt-2" style="border-top: 2px solid #efc120">
                                <span class="text-sm font-semibold text-gray-700">Jumla</span>
                                <span class="text-lg font-bold" style="color: #360958">{{ number_format($totalContributions ?? 0, 0) }} TZS</span>
                            </div>
                            <a href="{{ route('members.contributions', $member->id) }}" class="rx-btn rx-btn-primary w-full justify-center mt-3">
                                <i class="fas fa-list"></i> Angalia Yote
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3" style="background: rgba(239,193,32,0.1)">
                                <i class="fas fa-inbox text-lg" style="color: #efc120"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900 mb-1">Hakuna michango</p>
                            <p class="text-xs text-gray-400 mb-4">Muumini hana michango bado</p>
                            <button onclick="openSadakaModal('{{ $member->id }}')" class="rx-btn rx-btn-primary">
                                <i class="fas fa-plus"></i> Ongeza Sadaka
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-pie text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Takwimu</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-clock w-4 text-center text-gray-400"></i> Ujumbe</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->membership_date)->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-receipt w-4 text-center text-gray-400"></i> Michango</span>
                            <span class="text-sm font-medium text-gray-900">{{ $contributionCount ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-users w-4 text-center text-gray-400"></i> Kundi</span>
                            <span class="text-sm font-medium text-gray-900">
                                @php
                                    $age = \Carbon\Carbon::parse($member->date_of_birth)->age;
                                    echo $age < 18 ? 'Watoto' : ($age < 35 ? 'Vijana' : ($age < 60 ? 'Wazima' : 'Wazee'));
                                @endphp
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-calendar w-4 text-center text-gray-400"></i> Tangu</span>
                            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($member->membership_date)->format('Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-bolt text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Vitendo</h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="{{ route('members.edit', $member->id) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-edit text-blue-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Hariri Taarifa</p>
                            <p class="text-xs text-gray-400">Sasisha taarifa za muumini</p>
                        </div>
                    </a>
                    <button onclick="viewQrCode('{{ $member->id }}', '{{ $member->member_number }}')" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group text-left">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-qrcode text-purple-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">QR Code</p>
                            <p class="text-xs text-gray-400">Onyesha msimbo wa QR</p>
                        </div>
                    </button>
                    <button onclick="printMemberCard()" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group text-left">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-print text-emerald-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Print Kadi</p>
                            <p class="text-xs text-gray-400">Chapisha kadi ya muumini</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrCodeModal" class="modal-overlay hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-qrcode" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">QR Code</h3>
                    <p class="text-sm text-gray-500">{{ $member->first_name }} {{ $member->last_name }}</p>
                </div>
            </div>
            <button onclick="closeQrModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Namba ya Muumini</p>
            <p class="text-xl font-bold mb-4" style="color: #360958">{{ $member->member_number }}</p>
            <div id="qrCodeContainer" class="flex justify-center items-center bg-white p-6 rounded-xl border-2 border-gray-200 mb-4"></div>
            <p class="text-xs text-gray-400"><i class="fas fa-info-circle mr-1"></i> Scan QR code kupata taarifa</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
            <button onclick="printQrCode()" class="rx-btn rx-btn-primary">
                <i class="fas fa-print"></i> Print
            </button>
            <button onclick="closeQrModal()" class="rx-btn rx-btn-secondary">Funga</button>
        </div>
    </div>
</div>

<script>
function viewQrCode(memberId, memberNumber) {
    document.getElementById('qrMemberNumber') && (document.getElementById('qrMemberNumber').textContent = memberNumber);
    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = '<div class="text-gray-500 py-8"><i class="fas fa-spinner fa-spin text-3xl"></i><p class="mt-2 text-sm">Inapakia...</p></div>';
    fetch(`/panel/members/${memberId}/qrcode`)
        .then(response => response.text())
        .then(svg => {
            qrContainer.innerHTML = svg;
            document.getElementById('qrCodeModal').classList.remove('hidden');
            setTimeout(() => document.querySelector('#qrCodeModal > div').classList.remove('scale-95'), 10);
        })
        .catch(error => {
            qrContainer.innerHTML = '<p class="text-red-500 py-4"><i class="fas fa-exclamation-triangle mr-2"></i>Kuna hitilafu</p>';
        });
}

function closeQrModal() {
    const modal = document.getElementById('qrCodeModal');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

function printQrCode() {
    const memberNumber = '{{ $member->member_number }}';
    const qrCode = document.getElementById('qrCodeContainer').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`<html><head><title>QR - ${memberNumber}</title><style>body{font-family:sans-serif;text-align:center;padding:40px;background:white}h1{color:#360958;font-size:24px}.qr{display:inline-block;border:3px solid #360958;padding:30px;margin:30px 0;border-radius:10px}@media print{@page{margin:20mm}}</style></head><body><h1>ROC [Reality of Christ]</h1><h2 style="color:#666;font-size:16px">QR Code ya Muumini</h2><p style="font-size:28px;color:#360958;font-weight:bold">${memberNumber}</p><div class="qr">${qrCode}</div><p style="color:#666;font-size:14px">Scan QR code hii kupata taarifa</p><script>window.onload=function(){window.print();setTimeout(function(){window.close()},500)}<\/script></body></html>`);
    printWindow.document.close();
}

function printMemberCard() {
    window.print();
}

document.addEventListener('click', e => { if (e.target.id === 'qrCodeModal') closeQrModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeQrModal(); });
</script>
@endsection
