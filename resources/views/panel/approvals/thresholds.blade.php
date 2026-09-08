@extends('layouts.app')

@section('title', 'Kiwango cha Idhini - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('approvals.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-sliders-h" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kiwango cha Idhini</h1>
                <p class="text-sm text-gray-500">Simamia viwango vya idhini kulingana na kiasi</p>
            </div>
        </div>
    </div>

    <!-- Add New Threshold Form -->
    <div class="rx-card rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-plus-circle" style="color: #efc120"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900">Ongeza Kiwango Kipya</h3>
                <p class="text-xs text-gray-500">Weka kiwango kipya cha idhini kulingana na kiasi cha fedha</p>
            </div>
        </div>

        <form method="POST" action="{{ route('approvals.thresholds.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi cha Chini (TSh) <span class="text-red-500">*</span></label>
                    <input type="number" name="min_amount" value="{{ old('min_amount') }}" step="0.01" min="0" required placeholder="0.00" class="rx-input rx-input-no-icon @error('min_amount') !border-red-500 @enderror">
                    @error('min_amount')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi cha Juu (TSh)</label>
                    <input type="number" name="max_amount" value="{{ old('max_amount') }}" step="0.01" min="0" placeholder="Hakuna kikomo" class="rx-input rx-input-no-icon @error('max_amount') !border-red-500 @enderror">
                    @error('max_amount')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Muda Unaotarajiwa (masaa) <span class="text-red-500">*</span></label>
                    <input type="number" name="expected_hours" value="{{ old('expected_hours', 24) }}" min="1" required class="rx-input rx-input-no-icon @error('expected_hours') !border-red-500 @enderror">
                    @error('expected_hours')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Majukumu Yanayohitajika <span class="text-red-500">*</span></label>
                    <div class="space-y-1.5 mt-1">
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" name="required_roles[]" value="Mchungaji" {{ in_array('Mchungaji', old('required_roles', [])) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span>Mchungaji</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" name="required_roles[]" value="Mhasibu" {{ in_array('Mhasibu', old('required_roles', [])) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span>Mhasibu</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" name="required_roles[]" value="Mwanachama" {{ in_array('Mwanachama', old('required_roles', [])) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span>Mwanachama</span>
                        </label>
                    </div>
                    @error('required_roles')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end gap-3">
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer pb-2">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span>Hali: Imewashwa</span>
                    </label>
                    <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Hifadhi</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Thresholds Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center px-6 py-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-list text-xs" style="color: #efc120"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Viwango Vilivyopo</h3>
                <span class="rx-badge rx-badge-gray text-xs">{{ count($thresholds) }} viwango</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th>Kiwango</th>
                        <th>Majukumu</th>
                        <th>Muda</th>
                        <th>Hali</th>
                        <th class="text-center">Vitendo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($thresholds as $threshold)
                    <tr>
                        <td>
                            <div class="text-sm font-medium text-gray-900">
                                TZS {{ number_format($threshold->min_amount, 2) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                @if($threshold->max_amount)
                                    hadi TZS {{ number_format($threshold->max_amount, 2) }}
                                @else
                                    Hakuna kikomo cha juu
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-wrap gap-1.5">
                                @if($threshold->required_roles)
                                    @foreach($threshold->required_roles as $role)
                                        <span class="rx-badge rx-badge-purple text-[10px]">{{ $role }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-gray-400"></i>
                                {{ $threshold->expected_hours }} masaa
                            </div>
                        </td>
                        <td>
                            @if($threshold->is_active)
                                <span class="rx-badge rx-badge-green text-[10px]">
                                    <i class="fas fa-check-circle mr-1"></i> Imewashwa
                                </span>
                            @else
                                <span class="rx-badge rx-badge-gray text-[10px]">
                                    <i class="fas fa-times-circle mr-1"></i> Imezimwa
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" onclick="editThreshold({{ $threshold->id }}, {{ $threshold->min_amount }}, {{ $threshold->max_amount ?? 'null' }}, {{ $threshold->expected_hours }}, {{ json_encode($threshold->required_roles) }}, {{ $threshold->is_active ? 'true' : 'false' }})" class="rx-icon-btn rx-icon-btn-blue" title="Hariri">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button type="button" onclick="confirmDeleteThreshold({{ $threshold->id }})" class="rx-icon-btn rx-icon-btn-red" title="Futa">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="rx-empty">
                                <div class="rx-empty-icon">
                                    <i class="fas fa-sliders-h text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 mb-1">Hakuna viwango vilivyowekwa</h3>
                                <p class="text-sm text-gray-500">Ongeza kiwango kipya cha idhini hapo juu.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteThresholdModal" class="modal-overlay hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-exclamation-triangle text-xl" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Thibitisha Kufuta</h3>
                        <p class="text-sm text-gray-500">Hatua hii haiwezi kurudishwa</p>
                    </div>
                </div>
                <button type="button" onclick="closeDeleteThresholdModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-2">Je, una uhakika unataka kufuta kiwango hiki?</p>
            <p class="text-sm text-red-600 mt-3">
                <i class="fas fa-warning mr-1"></i>
                Taarifa zote za kiwango hili zitafutwa kabisa.
            </p>
        </div>
        <div class="sticky bottom-0 bg-gray-50 px-6 py-5 rounded-b-2xl border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteThresholdModal()" class="rx-btn rx-btn-secondary">Ghairi</button>
            <form id="deleteThresholdForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="rx-btn rx-btn-danger flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    <span>Futa Kiwango</span>
                </button>
            </form>
        </div>
    </div>
</div>

@include('partials.loading-modal')

<script>
function confirmDeleteThreshold(id) {
    document.getElementById('deleteThresholdForm').action = '{{ url("panel/approvals-thresholds") }}/' + id;
    var modal = document.getElementById('deleteThresholdModal');
    modal.classList.remove('hidden');
    setTimeout(function() { modal.querySelector('div').classList.remove('scale-95'); }, 10);
}

function closeDeleteThresholdModal() {
    var modal = document.getElementById('deleteThresholdModal');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(function() { modal.classList.add('hidden'); }, 300);
}

document.addEventListener('click', function(event) {
    var modal = document.getElementById('deleteThresholdModal');
    if (event.target === modal) { closeDeleteThresholdModal(); }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        var modal = document.getElementById('deleteThresholdModal');
        if (!modal.classList.contains('hidden')) { closeDeleteThresholdModal(); }
    }
});

function editThreshold(id, minAmount, maxAmount, expectedHours, roles, isActive) {
    document.querySelector('[name="min_amount"]').value = minAmount;
    document.querySelector('[name="max_amount"]').value = maxAmount || '';
    document.querySelector('[name="expected_hours"]').value = expectedHours;

    document.querySelectorAll('[name="required_roles[]"]').forEach(function(cb) {
        cb.checked = roles.indexOf(cb.value) !== -1;
    });

    document.querySelector('[name="is_active"]').checked = isActive;

    document.querySelector('[name="min_amount"]').focus();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection