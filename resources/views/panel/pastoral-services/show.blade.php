@extends('layouts.app')

@section('title', 'Taarifa za Huduma - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('pastoral-services.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-hands-praying" style="color: #efc120"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Taarifa za Huduma</h1>
                    <p class="text-sm text-gray-500">Angalia maelezo kamili ya ombi la huduma</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($service->status == 'Inasubiri')
            <a href="{{ route('pastoral-services.edit', $service->id) }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
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
                    <i class="fas fa-hands-praying text-white text-3xl"></i>
                </div>
                <div class="flex-1 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $service->service_type }}</h2>
                            <div class="flex items-center gap-4 mt-2 flex-wrap">
                                <div class="flex items-center gap-2 text-sm opacity-90">
                                    <i class="fas fa-hashtag"></i>
                                    <span>{{ $service->service_number }}</span>
                                </div>
                                @if($service->status == 'Inasubiri')
                                    <span class="rx-badge text-xs" style="background: rgba(239,193,32,0.9); color: #360958;"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                                @elseif($service->status == 'Imeidhinishwa')
                                    <span class="rx-badge text-xs" style="background: rgba(34,197,94,0.9); color: white;"><i class="fas fa-check-circle mr-1"></i>Imeidhinishwa</span>
                                @elseif($service->status == 'Imekamilika')
                                    <span class="rx-badge text-xs" style="background: rgba(124,58,237,0.9); color: white;"><i class="fas fa-check-double mr-1"></i>Imekamilika</span>
                                @else
                                    <span class="rx-badge text-xs" style="background: rgba(239,68,68,0.9); color: white;"><i class="fas fa-times-circle mr-1"></i>Imekataliwa</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Taarifa za Muumini -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Muumini</h3>
                        <p class="text-xs text-gray-500">Muumini aliyeomba huduma</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Jina la Muumini</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-circle text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $service->member->first_name }} {{ $service->member->middle_name }} {{ $service->member->last_name }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Namba ya Muumini</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-id-card text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $service->member->member_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Taarifa za Huduma -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Huduma</h3>
                        <p class="text-xs text-gray-500">Maelezo ya ombi la huduma</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Aina ya Huduma</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hands-praying text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $service->service_type }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Tarehe Inayopendelewa</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $service->preferred_date ? \Carbon\Carbon::parse($service->preferred_date)->format('d/m/Y') : 'Haijachaguliwa' }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Tarehe ya Kuomba</p>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-sm" style="color: #efc120"></i>
                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($service->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-1">Hali</p>
                        <div class="flex items-center gap-2">
                            @if($service->status == 'Inasubiri')
                                <span class="rx-badge rx-badge-yellow text-xs"><i class="fas fa-clock mr-1"></i>Inasubiri</span>
                            @elseif($service->status == 'Imeidhinishwa')
                                <span class="rx-badge rx-badge-green text-xs"><i class="fas fa-check-circle mr-1"></i>Imeidhinishwa</span>
                            @elseif($service->status == 'Imekamilika')
                                <span class="rx-badge text-xs" style="background: rgba(124,58,237,0.1); color: #7c3aed;"><i class="fas fa-check-double mr-1"></i>Imekamilika</span>
                            @else
                                <span class="rx-badge rx-badge-red text-xs"><i class="fas fa-times-circle mr-1"></i>Imekataliwa</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            @if($service->description)
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-align-left" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo Zaidi</h3>
                        <p class="text-xs text-gray-500">Maelezo kamili kuhusu ombi hili</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-quote-left text-sm mt-1" style="color: #efc120"></i>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Maoni ya Msimamizi -->
            @if($service->admin_notes)
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                        <i class="fas fa-comment-dots" style="color: #3b82f6"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maoni ya Msimamizi</h3>
                        <p class="text-xs text-gray-500">Maoni kutoka kwa mchungaji/msimamizi</p>
                    </div>
                </div>
                <div class="rounded-xl p-4 border" style="background: rgba(59,130,246,0.05); border-color: rgba(59,130,246,0.2)">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle text-sm mt-1" style="color: #3b82f6"></i>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $service->admin_notes }}</p>
                            @if($service->approver)
                            <p class="text-xs text-blue-600 mt-3">
                                - {{ $service->approver->name }} ({{ \Carbon\Carbon::parse($service->approved_at)->format('d/m/Y H:i') }})
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Muhtasari -->
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-chart-line" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Muhtasari</h3>
                        <p class="text-xs text-gray-500">Taarifa za haraka za ombi</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hands-praying text-xs" style="color: #7c3aed"></i>
                            <span class="text-xs text-gray-700">Aina ya Huduma</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $service->service_type }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-xs" style="color: #3b82f6"></i>
                            <span class="text-xs text-gray-700">Tarehe ya Ombi</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($service->created_at)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-xs" style="color: #16a34a"></i>
                            <span class="text-xs text-gray-700">Muda Tangu Kuomba</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($service->created_at)->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Vitendo vya Msimamizi -->
            @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                @if($service->status == 'Inasubiri')
                <div class="rx-card rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-tasks" style="color: #efc120"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Vitendo vya Msimamizi</h3>
                            <p class="text-xs text-gray-500">Chagua kitendo kwa ombi hili</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <button onclick="openModal('approveModal')" class="rx-btn rx-btn-primary w-full justify-center py-3 flex items-center gap-2" style="background: #16a34a; color: white;">
                            <i class="fas fa-check"></i>
                            <span>Idhinisha Huduma</span>
                        </button>
                        <button onclick="openModal('rejectModal')" class="rx-btn w-full justify-center py-3 flex items-center gap-2" style="background: #ef4444; color: white;">
                            <i class="fas fa-times"></i>
                            <span>Kataa Huduma</span>
                        </button>
                    </div>
                </div>
                @elseif($service->status == 'Imeidhinishwa')
                <div class="rx-card rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-tasks" style="color: #efc120"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Vitendo vya Msimamizi</h3>
                            <p class="text-xs text-gray-500">Thibitisha ukamilishaji wa huduma</p>
                        </div>
                    </div>
                    <button onclick="openModal('completeModal')" class="rx-btn w-full justify-center py-3 flex items-center gap-2" style="background: #7c3aed; color: white;">
                        <i class="fas fa-check-double"></i>
                        <span>Weka Kama Imekamilika</span>
                    </button>
                </div>
                @endif
            @endif

            <!-- Hatari -->
            @if($service->status == 'Inasubiri')
            <div class="rx-card rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-trash" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Hatari</h3>
                        <p class="text-xs text-gray-500">Futa ombi hili kabisa</p>
                    </div>
                </div>
                <form action="{{ route('pastoral-services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Je, una uhakika unataka kufuta ombi hili?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rx-btn w-full justify-center py-3 flex items-center gap-2" style="background: #ef4444; color: white;">
                        <i class="fas fa-trash"></i>
                        <span>Futa Ombi</span>
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
@if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
    @if($service->status == 'Inasubiri')
    <div id="approveModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
            <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(22,163,74,0.1)">
                            <i class="fas fa-check-circle text-xl" style="color: #16a34a"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Idhinisha Huduma</h3>
                            <p class="text-sm text-gray-600">{{ $service->service_type }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('approveModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('pastoral-services.approve', $service->id) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div class="rounded-xl p-4 border-l-4" style="background: rgba(59,130,246,0.05); border-left-color: #3b82f6">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-sm mt-0.5" style="color: #3b82f6"></i>
                            <div>
                                <p class="text-sm font-semibold" style="color: #1e40af">Taarifa za Huduma</p>
                                <p class="text-sm text-gray-700 mt-1">{{ $service->service_type }} - {{ $service->member->first_name }} {{ $service->member->last_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maoni (Si lazima)</label>
                        <textarea name="admin_notes" rows="4" class="rx-input rx-input-no-icon" placeholder="Andika maoni yako hapa..."></textarea>
                    </div>
                </div>
                <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('approveModal')" class="rx-btn rx-btn-secondary">Funga</button>
                    <button type="submit" class="rx-btn flex items-center gap-2" style="background: #16a34a; color: white;">
                        <i class="fas fa-check"></i>
                        <span>Idhinisha</span>
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
                            <h3 class="text-lg font-bold text-gray-900">Kataa Huduma</h3>
                            <p class="text-sm text-gray-600">{{ $service->service_type }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('rejectModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('pastoral-services.reject', $service->id) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div class="rounded-xl p-4 border-l-4" style="background: rgba(202,138,4,0.05); border-left-color: #ca8a04">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle text-sm mt-0.5" style="color: #ca8a04"></i>
                            <p class="text-sm text-gray-700">Una uhakika unataka kukataa ombi hili la huduma? Hatua hii haiwezi kufutwa.</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Sababu ya Kukataa <span class="text-red-500">*</span></label>
                        <textarea name="admin_notes" rows="5" required class="rx-input rx-input-no-icon" placeholder="Eleza sababu ya kukataa ombi hili..."></textarea>
                    </div>
                </div>
                <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('rejectModal')" class="rx-btn rx-btn-secondary">Funga</button>
                    <button type="submit" class="rx-btn rx-btn-danger flex items-center gap-2">
                        <i class="fas fa-times"></i>
                        <span>Kataa</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($service->status == 'Imeidhinishwa')
    <!-- Complete Modal -->
    <div id="completeModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
            <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(124,58,237,0.1)">
                            <i class="fas fa-check-double text-xl" style="color: #7c3aed"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Kamilisha Huduma</h3>
                            <p class="text-sm text-gray-600">{{ $service->service_type }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('completeModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('pastoral-services.complete', $service->id) }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="rounded-xl p-4 border-l-4" style="background: rgba(59,130,246,0.05); border-left-color: #3b82f6">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-sm mt-0.5" style="color: #3b82f6"></i>
                            <div>
                                <p class="text-sm font-semibold" style="color: #1e40af">Thibitisha Ukamilishaji</p>
                                <p class="text-sm text-gray-700 mt-1">Je, huduma hii ya <strong>{{ $service->service_type }}</strong> imekamilika?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('completeModal')" class="rx-btn rx-btn-secondary">Funga</button>
                    <button type="submit" class="rx-btn flex items-center gap-2" style="background: #7c3aed; color: white;">
                        <i class="fas fa-check-double"></i>
                        <span>Ndiyo, Imekamilika</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endif

@endsection

@section('scripts')
<script>
function openModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(function() { modal.querySelector('div').classList.remove('scale-95'); }, 10);
    }
}

function closeModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(function() { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }, 200);
    }
}

document.querySelectorAll('[id$="Modal"]').forEach(function(m) {
    m.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.querySelectorAll('[id$="Modal"]:not(.hidden)').forEach(function(m) { closeModal(m.id); });
});
</script>
@endsection
