@extends('layouts.app')

@section('title', 'Huduma za Kichungaji - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-hands-praying" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Huduma za Kichungaji</h1>
                <p class="text-sm text-gray-500">Usimamizi kamili wa maombi ya huduma za kichungaji</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            @if(!Auth::user()->isMwanachama())
            <a href="{{ route('pastoral-services.report') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-chart-bar"></i>
                <span class="hidden sm:inline">Ripoti</span>
            </a>
            <button onclick="openModal('exportModal')" class="rx-btn rx-btn-secondary flex items-center gap-2" style="color: #ef4444; border-color: rgba(239,68,68,0.2);">
                <i class="fas fa-file-pdf"></i>
                <span class="hidden sm:inline">Export PDF</span>
            </button>
            @endif
            <a href="{{ route('pastoral-services.create') }}" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Omba Huduma</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        <div class="rx-card rounded-2xl p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Jumla</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-list" style="color: #360958"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Zinasubiri</p>
                    <p class="text-xl font-bold" style="color: #ca8a04">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(202,138,4,0.1)">
                    <i class="fas fa-clock" style="color: #ca8a04"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Zimeidhinishwa</p>
                    <p class="text-xl font-bold" style="color: #16a34a">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-check-circle" style="color: #16a34a"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Zimekamilika</p>
                    <p class="text-xl font-bold" style="color: #7c3aed">{{ $stats['completed'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(124,58,237,0.1)">
                    <i class="fas fa-check-double" style="color: #7c3aed"></i>
                </div>
            </div>
        </div>
        <div class="rx-card rounded-2xl p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mb-1">Zimekataliwa</p>
                    <p class="text-xl font-bold" style="color: #ef4444">{{ $stats['rejected'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-times-circle" style="color: #ef4444"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    @if(!Auth::user()->isMwanachama())
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-filter" style="color: #efc120"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Chuja Maombi</h3>
                    <p class="text-xs text-gray-500">Chuja kwa hali, aina na tarehe</p>
                </div>
            </div>
            <form method="GET" action="{{ route('pastoral-services.index') }}" data-auto-filter="true" data-ajax-target="#pastoralTableContainer">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali</label>
                        <select name="status" class="rx-select">
                            <option value="">Zote</option>
                            <option value="Inasubiri" {{ request('status') == 'Inasubiri' ? 'selected' : '' }}>Zinasubiri</option>
                            <option value="Imeidhinishwa" {{ request('status') == 'Imeidhinishwa' ? 'selected' : '' }}>Zimeidhinishwa</option>
                            <option value="Imekamilika" {{ request('status') == 'Imekamilika' ? 'selected' : '' }}>Zimekamilika</option>
                            <option value="Imekataliwa" {{ request('status') == 'Imekataliwa' ? 'selected' : '' }}>Zimekataliwa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Huduma</label>
                        <select name="service_type" class="rx-select">
                            <option value="">Zote</option>
                            @foreach($serviceTypes as $type)
                                <option value="{{ $type }}" {{ request('service_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Kuanzia</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="rx-input rx-input-no-icon">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe Mwisho</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="rx-input rx-input-no-icon">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                        <i class="fas fa-search"></i>
                        <span>Tafuta</span>
                    </button>
                    <a href="{{ route('pastoral-services.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                        <i class="fas fa-redo"></i>
                        <span>Futa</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="rx-card rounded-2xl overflow-hidden" id="pastoralTableContainer">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list" style="color: #efc120"></i>
                Orodha ya Maombi ya Huduma
                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
                    {{ $services->total() }} total
                </span>
            </h3>
            <p class="text-sm text-gray-500">
                Kuonyesha {{ $services->firstItem() }} - {{ $services->lastItem() }} ya {{ $services->total() }}
            </p>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Namba</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-user text-xs" style="color: #efc120"></i>
                                <span>Muumini</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hands-praying text-xs" style="color: #efc120"></i>
                                <span>Aina ya Huduma</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-calendar-day text-xs" style="color: #efc120"></i>
                                <span>Tarehe Inayopendelewa</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                                <span>Hali</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                                <span>Tarehe ya Kuomba</span>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                                <span>Vitendo</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr class="transition-colors">
                        <!-- Service Number -->
                        <td>
                            <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $service->service_number }}</span>
                        </td>

                        <!-- Member -->
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                                    <i class="fas fa-user text-xs" style="color: #efc120"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">{{ $service->member->first_name }} {{ $service->member->last_name }}</span>
                                    <p class="text-[11px] text-gray-500">{{ $service->member->member_number }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Service Type -->
                        <td>
                            <span class="rx-badge rx-badge-blue">
                                <i class="fas fa-hands-praying mr-1"></i>{{ $service->service_type }}
                            </span>
                        </td>

                        <!-- Preferred Date -->
                        <td>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-calendar-day text-gray-400 text-xs"></i>
                                @if($service->preferred_date)
                                    {{ \Carbon\Carbon::parse($service->preferred_date)->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td>
                            @if($service->status == 'Inasubiri')
                                <span class="rx-badge rx-badge-yellow">
                                    <i class="fas fa-clock mr-1"></i>Inasubiri
                                </span>
                            @elseif($service->status == 'Imeidhinishwa')
                                <span class="rx-badge rx-badge-green">
                                    <i class="fas fa-check-circle mr-1"></i>Imeidhinishwa
                                </span>
                            @elseif($service->status == 'Imekamilika')
                                <span class="rx-badge" style="background: #f3e8ff; color: #7c3aed;">
                                    <i class="fas fa-check-double mr-1"></i>Imekamilika
                                </span>
                            @else
                                <span class="rx-badge rx-badge-red">
                                    <i class="fas fa-times-circle mr-1"></i>Imekataliwa
                                </span>
                            @endif
                        </td>

                        <!-- Application Date -->
                        <td>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                {{ \Carbon\Carbon::parse($service->created_at)->format('d/m/Y') }}
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('pastoral-services.show', $service->id) }}" class="rx-icon-btn rx-icon-btn-blue" title="Angalia Maelezo">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                @if($service->status == 'Inasubiri')
                                <a href="{{ route('pastoral-services.edit', $service->id) }}" class="rx-icon-btn rx-icon-btn-gold" title="Hariri">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </a>
                                <button type="button" onclick="confirmDelete({{ $service->id }}, '{{ $service->service_type }}', '{{ $service->member->first_name }} {{ $service->member->last_name }}')" class="rx-icon-btn rx-icon-btn-red" title="Futa">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="rx-empty">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-hands-praying text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-900 mb-1">Hakuna Maombi Yaliyopatikana</p>
                                <p class="text-xs text-gray-400 mb-4">Hakuna maombi ya huduma yanayolingana na vichujio vyako.</p>
                                <a href="{{ route('pastoral-services.create') }}" class="rx-btn rx-btn-primary">
                                    <i class="fas fa-plus"></i> Omba Huduma Mpya
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-exclamation-triangle text-xl" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Thibitisha Kufuta</h3>
                        <p class="text-sm text-gray-600">Hatua hii haiwezi kurudishwa</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('deleteModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-2">Je, una uhakika unataka kufuta ombi hili la huduma?</p>
            <div class="bg-gray-50 rounded-xl p-3 mb-4">
                <p class="text-sm text-gray-600">Huduma: <span class="font-semibold text-gray-900" id="deleteServiceType"></span></p>
                <p class="text-sm text-gray-600">Muumini: <span class="font-semibold text-gray-900" id="deleteServiceMember"></span></p>
            </div>
            <p class="text-sm" style="color: #ef4444"><i class="fas fa-warning mr-1"></i> Taarifa zote za ombi hili zitafutwa kabisa.</p>
        </div>
        <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
            <button type="button" onclick="closeModal('deleteModal')" class="rx-btn rx-btn-secondary">Ghairi</button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="rx-btn rx-btn-danger flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    <span>Futa Ombi</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Export PDF Modal -->
<div id="exportModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-file-pdf text-xl" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Export Ripoti (PDF)</h3>
                        <p class="text-sm text-gray-500">Chagua kipindi cha ripoti</p>
                    </div>
                </div>
                <button onclick="closeModal('exportModal')" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form id="exportForm" action="{{ route('pastoral-services.export') }}" method="GET">
            <input type="hidden" name="format" value="pdf">
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Kipindi cha Ripoti</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="period" value="week" class="peer sr-only">
                            <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-gray-300">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" style="background: rgba(54,9,88,0.08)"><i class="fas fa-calendar-week" style="color: #360958"></i></div>
                                <span class="text-xs font-medium text-gray-700">Wiki Hii</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="period" value="month" class="peer sr-only" checked>
                            <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-gray-300">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" style="background: rgba(22,163,74,0.1)"><i class="fas fa-calendar-alt" style="color: #16a34a"></i></div>
                                <span class="text-xs font-medium text-gray-700">Mwezi Huu</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="period" value="year" class="peer sr-only">
                            <div class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all hover:border-gray-300">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-2" style="background: rgba(124,58,237,0.1)"><i class="fas fa-calendar" style="color: #7c3aed"></i></div>
                                <span class="text-xs font-medium text-gray-700">Mwaka Huu</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hali (Hiari)</label>
                    <select name="status" class="rx-select">
                        <option value="">Hali Zote</option>
                        <option value="Inasubiri">Zinasubiri</option>
                        <option value="Imeidhinishwa">Zimeidhinishwa</option>
                        <option value="Imekamilika">Zimekamilika</option>
                        <option value="Imekataliwa">Zimekataliwa</option>
                    </select>
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeModal('exportModal')" class="rx-btn rx-btn-secondary">Ghairi</button>
                <button type="button" onclick="exportPDF()" class="rx-btn rx-btn-danger flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i>
                    <span>Download PDF</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@include('partials.loading-modal')
<script>
function confirmDelete(id, type, name) {
    document.getElementById('deleteServiceType').textContent = type;
    document.getElementById('deleteServiceMember').textContent = name;
    document.getElementById('deleteForm').action = '/panel/pastoral-services/' + id;
    openModal('deleteModal');
}

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

function exportPDF() {
    var form = document.getElementById('exportForm');
    var formData = new FormData(form);
    var params = new URLSearchParams(formData);
    var loadingModal = document.getElementById('loadingModal');
    var progressBar = document.getElementById('progressBar');
    var loadingMessage = document.getElementById('loadingMessage');

    loadingMessage.textContent = 'Inatengeneza ripoti ya PDF...';
    loadingModal.classList.remove('hidden');

    var progress = 0;
    var interval = setInterval(function() {
        progress += Math.random() * 15;
        if (progress > 90) progress = 90;
        progressBar.style.width = progress + '%';
    }, 200);

    fetch('{{ route('pastoral-services.export.pdf') }}?' + params.toString(), {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(function(res) { return res.json().catch(function() { return {}; }); })
    .then(function(data) {
        clearInterval(interval);
        progressBar.style.width = '100%';
        setTimeout(function() {
            loadingModal.classList.add('hidden');
            progressBar.style.width = '0%';
            if (data.success && data.download_url && data.download_url !== '#') {
                var link = document.createElement('a');
                link.href = data.download_url;
                link.download = data.filename || 'huduma_za_kichungaji.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                showFlashNotification('Hitilafu: ' + (data.message || 'Tumeshindwa kutengeneza ripoti'), 'error');
            }
        }, 500);
    })
    .catch(function() {
        clearInterval(interval);
        loadingModal.classList.add('hidden');
        progressBar.style.width = '0%';
        showFlashNotification('Hitilafu ya mtandao! Tafadhali jaribu tena.', 'error');
    });
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
