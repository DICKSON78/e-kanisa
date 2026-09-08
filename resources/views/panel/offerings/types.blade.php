@extends('layouts.app')

@section('title', 'Aina za Sadaka - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-list" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Aina za Sadaka</h1>
                <p class="text-sm text-gray-500">Usimamizi wa aina za sadaka za kanisa</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('offerings.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span class="hidden sm:inline">Rudi</span>
            </a>
            <button onclick="openAddTypeModal()" class="rx-btn rx-btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Ongeza Aina Mpya</span>
            </button>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list" style="color: #efc120"></i>
                Orodha ya Aina za Sadaka
                <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
                    {{ $categories->count() }} aina
                </span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                                <span>Code</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                                <span>Jina</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                                <span>Maelezo</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                                <span>Hali</span>
                            </div>
                        </th>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <th class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                                <span>Vitendo</span>
                            </div>
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="transition-colors">
                        <!-- Code -->
                        <td>
                            <span class="text-sm font-mono text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $category->code ?? '-' }}</span>
                        </td>

                        <!-- Name -->
                        <td>
                            <span class="text-sm font-semibold text-gray-900">{{ $category->name }}</span>
                        </td>

                        <!-- Description -->
                        <td>
                            <span class="text-sm text-gray-600">{{ $category->description ?? '-' }}</span>
                        </td>

                        <!-- Status -->
                        <td>
                            @if($category->is_active)
                                <span class="rx-badge rx-badge-success">
                                    <i class="fas fa-check-circle mr-1"></i> Hai
                                </span>
                            @else
                                <span class="rx-badge rx-badge-danger">
                                    <i class="fas fa-times-circle mr-1"></i> Si Hai
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editCategory({{ $category->id }})" class="rx-icon-btn rx-icon-btn-purple" title="Hariri">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 5 : 4 }}" class="text-center py-16">
                            <div class="rx-empty">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                <h3 class="rx-empty-title">Hakuna Aina za Sadaka</h3>
                                <p class="rx-empty-description">Bado hujaongeza aina yoyote ya sadaka.</p>
                                <button onclick="openAddTypeModal()" class="rx-btn rx-btn-primary mt-4 inline-flex items-center gap-2">
                                    <i class="fas fa-plus"></i> Ongeza Aina Mpya
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Type Modal -->
<div id="addTypeModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="addTypeModalContent">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-100 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-plus" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Ongeza Aina Mpya ya Sadaka</h3>
                        <p class="text-xs text-gray-500">Jaza taarifa za aina mpya</p>
                    </div>
                </div>
                <button type="button" onclick="closeAddTypeModal()" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <form method="POST" action="{{ route('offerings.types.store') }}">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                        Jina <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-400"></i>
                        </div>
                        <input type="text" id="name" name="name" required
                               class="rx-input" placeholder="Jina la aina ya sadaka">
                    </div>
                </div>
                <div>
                    <label for="code" class="block text-sm font-semibold text-gray-900 mb-2">
                        Code
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-hashtag text-gray-400"></i>
                        </div>
                        <input type="text" id="code" name="code"
                               class="rx-input" placeholder="Code ya aina">
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                        Maelezo
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="rx-input" placeholder="Maelezo ya aina hii..."></textarea>
                </div>
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm text-gray-700">Aina hii ni hai</span>
                    </label>
                </div>
            </div>
            <div class="sticky bottom-0 flex justify-end gap-3 px-6 py-5 bg-gray-50 rounded-b-2xl border-t border-gray-100">
                <button type="button" onclick="closeAddTypeModal()" class="rx-btn rx-btn-secondary">
                    Ghairi
                </button>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Hifadhi</span>
                </button>
            </div>
        </form>
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
<div id="alertModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[10000]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95" id="alertModalContent">
        <div class="p-6 text-center">
            <div id="alertIcon" class="h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i id="alertIconClass" class="text-3xl"></i>
            </div>
            <h3 id="alertTitle" class="text-xl font-bold text-gray-900 mb-2">Ujumbe</h3>
            <p id="alertMessage" class="text-gray-500 text-sm mb-6">Ujumbe hapa</p>
            <button onclick="closeAlertModal()" class="rx-btn rx-btn-primary w-full">
                <i class="fas fa-check mr-1"></i> Sawa, Nimeelewa
            </button>
        </div>
    </div>
</div>

@section('scripts')
<script>
function openAddTypeModal() {
    const modal = document.getElementById('addTypeModal');
    const content = document.getElementById('addTypeModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function closeAddTypeModal() {
    const modal = document.getElementById('addTypeModal');
    const content = document.getElementById('addTypeModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

function editCategory(id) {
    showAlert('info', 'Taarifa', 'Utendakazi wa kuhariri aina utaongezwa hivi karibuni.');
}

// Alert Modal Functions
function showAlert(type, title, message) {
    const modal = document.getElementById('alertModal');
    const content = document.getElementById('alertModalContent');
    const iconContainer = document.getElementById('alertIcon');
    const iconClass = document.getElementById('alertIconClass');
    const titleEl = document.getElementById('alertTitle');
    const messageEl = document.getElementById('alertMessage');

    if (!modal) { alert(title + ': ' + message); return; }

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

function closeAlertModal() {
    const modal = document.getElementById('alertModal');
    const content = document.getElementById('alertModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

function closeConfirmActionModal() {
    const modal = document.getElementById('confirmActionModal');
    const content = document.getElementById('confirmActionModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

// Modal backdrop/escape close
document.getElementById('addTypeModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAddTypeModal();
});
document.getElementById('confirmActionModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirmActionModal();
});
document.getElementById('alertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAlertModal();
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAddTypeModal();
        closeConfirmActionModal();
        closeAlertModal();
    }
});

// Show flash messages
@if(session('success'))
    showAlert('success', 'Imefanikiwa!', '{{ session('success') }}');
@endif
@if(session('error'))
    showAlert('error', 'Hitilafu!', '{{ session('error') }}');
@endif
</script>
@endsection
