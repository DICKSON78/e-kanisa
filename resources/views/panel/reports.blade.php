@extends('layouts.app')

@section('title', 'Ripoti - Mfumo wa E-Kanisa')
@section('page-title', 'Ripoti za Fedha')
@section('page-subtitle', 'Tengeneza na pakua ripoti za fedha za kitaalamu')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-file-pdf" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ripoti za Fedha</h1>
                <p class="text-sm text-gray-500">Tengeneza na pakua ripoti za fedha za {{ $settings->company_name ?? 'E-Kanisa' }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Report Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Wiki -->
        <div class="rx-card rounded-2xl overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                        <i class="fas fa-calendar-week text-xl" style="color: #3b82f6"></i>
                    </div>
                    <span class="rx-badge rx-badge-blue">Wiki</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Ripoti ya Kila Wiki</h3>
                <p class="text-xs text-gray-500 mb-4">Muhtasari wa mapato na matumizi ya wiki iliyopita</p>
                <button onclick="generateReport('weekly')" class="w-full rx-btn rx-btn-sm flex items-center justify-center gap-2" id="btn-weekly" style="background: rgba(59,130,246,0.08); color: #3b82f6;">
                    <i class="fas fa-file-pdf"></i>
                    <span class="btn-text">Pakua PDF</span>
                </button>
            </div>
        </div>

        <!-- Mwezi -->
        <div class="rx-card rounded-2xl overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(124,58,237,0.1)">
                        <i class="fas fa-calendar-alt text-xl" style="color: #7c3aed"></i>
                    </div>
                    <span class="rx-badge rx-badge-purple">Mwezi</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Ripoti ya Kila Mwezi</h3>
                <p class="text-xs text-gray-500 mb-4">Muhtasari wa mapato na matumizi ya mwezi uliopita</p>
                <button onclick="generateReport('monthly')" class="w-full rx-btn rx-btn-sm flex items-center justify-center gap-2" id="btn-monthly" style="background: rgba(124,58,237,0.08); color: #7c3aed;">
                    <i class="fas fa-file-pdf"></i>
                    <span class="btn-text">Pakua PDF</span>
                </button>
            </div>
        </div>

        <!-- Mwaka -->
        <div class="rx-card rounded-2xl overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar text-xl" style="color: #efc120"></i>
                    </div>
                    <span class="rx-badge rx-badge-yellow">Mwaka</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Ripoti ya Kila Mwaka</h3>
                <p class="text-xs text-gray-500 mb-4">Muhtasari wa mapato na matumizi ya mwaka mzima</p>
                <button onclick="generateReport('yearly')" class="w-full rx-btn rx-btn-sm flex items-center justify-center gap-2" id="btn-yearly" style="background: rgba(239,193,32,0.08); color: #d4a81c;">
                    <i class="fas fa-file-pdf"></i>
                    <span class="btn-text">Pakua PDF</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Jumla ya Ripoti</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $recentExports->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(54,9,88,0.08)">
                    <i class="fas fa-folder-open" style="color: #360958"></i>
                </div>
            </div>
        </div>
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Mapato</p>
                    <p class="text-2xl font-bold" style="color: #16a34a">{{ $recentExports->where('type', 'mapato')->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(22,163,74,0.1)">
                    <i class="fas fa-hand-holding-usd" style="color: #16a34a"></i>
                </div>
            </div>
        </div>
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Matumizi</p>
                    <p class="text-2xl font-bold text-red-600">{{ $recentExports->where('type', 'matumizi')->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-receipt" style="color: #ef4444"></i>
                </div>
            </div>
        </div>
        <div class="rx-stat-card rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Zilizopo</p>
                    <p class="text-2xl font-bold" style="color: #360958">{{ $recentExports->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-check-circle" style="color: #efc120"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="rx-card rounded-xl p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tafuta</label>
                <div class="rx-search">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/></svg>
                    <input id="searchExport" type="text" placeholder="Tafuta kwa jina, aina, au tarehe...">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina</label>
                <select id="filterType" class="rx-select">
                    <option value="">Zote</option>
                    <option value="mapato">Mapato</option>
                    <option value="matumizi">Matumizi</option>
                    <option value="mapato_matumizi">Mapato na Matumizi</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-pdf" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Ripoti Zilizotengenezwa</h3>
                        <p class="text-xs text-gray-500">{{ $recentExports->count() }} ripoti</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="location.reload()" class="rx-icon-btn rx-icon-btn-gray" title="Fresha">
                        <i class="fas fa-sync-alt text-xs"></i>
                    </button>
                    <button onclick="openBulkDeleteModal()" id="deleteSelectedBtn" class="rx-icon-btn rx-icon-btn-red hidden" title="Futa Zilizochaguliwa">
                        <i class="fas fa-trash text-xs"></i>
                        <span id="deleteCount" class="text-xs ml-1">0</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="rx-table">
                <thead>
                    <tr>
                        <th class="w-12 text-center">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-file text-xs" style="color: #efc120"></i>
                                <span>Jina la Ripoti</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-tag text-xs" style="color: #efc120"></i>
                                <span>Aina</span>
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
                                <i class="fas fa-hdd text-xs" style="color: #efc120"></i>
                                <span>Ukubwa</span>
                            </div>
                        </th>
                        <th>
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                                <span>Tarehe</span>
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
                <tbody id="exportsTable">
                    @forelse($recentExports as $export)
                    @php
                        $typeBadge = match($export->type) {
                            'mapato', 'sadaka' => 'rx-badge-green',
                            'kiwanja' => 'rx-badge-blue',
                            'matumizi' => 'rx-badge-red',
                            default => 'rx-badge-purple',
                        };
                        $typeIcon = match($export->type) {
                            'mapato', 'sadaka' => 'fas fa-hand-holding-usd',
                            'kiwanja' => 'fas fa-hands-praying',
                            'matumizi' => 'fas fa-money-bill-wave',
                            default => 'fas fa-chart-pie',
                        };
                    @endphp
                    <tr class="transition-colors export-row"
                        data-filename="{{ strtolower($export->filename) }}"
                        data-type="{{ strtolower($export->type) }}"
                        data-description="{{ strtolower($export->description ?? '') }}">
                        <td class="text-center">
                            <input type="checkbox" name="export_ids[]" value="{{ $export->id }}" class="export-checkbox w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                                    <i class="fas fa-file-pdf text-xs" style="color: #ef4444"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $export->filename }}</div>
                                    <div class="text-[11px] text-gray-400 font-mono">#{{ $export->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="rx-badge {{ $typeBadge }}">
                                <i class="{{ $typeIcon }} mr-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $export->type)) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-600 max-w-xs truncate block">{{ $export->description }}</span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-600 font-medium">{{ $export->human_size }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                {{ $export->created_at->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($export->download_url !== '#')
                                <a href="{{ route('export.excel.download', $export->id) }}" class="rx-icon-btn rx-icon-btn-green" title="Pakua">
                                    <i class="fas fa-download text-xs"></i>
                                </a>
                                @else
                                <span class="rx-icon-btn rx-icon-btn-gray opacity-50 cursor-not-allowed" title="Haipatikani">
                                    <i class="fas fa-download text-xs"></i>
                                </span>
                                @endif
                                <button onclick="deleteExport('{{ $export->id }}')" class="rx-icon-btn rx-icon-btn-red" title="Futa">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="rx-empty">
                                <div class="rx-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <p class="rx-empty-title">Hakuna ripoti bado</p>
                                <p class="rx-empty-desc">Bofya kitufe hapo juu kutengeneza ripoti yako ya kwanza</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulkDeleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-[9999]">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white px-6 py-5 rounded-t-2xl border-b border-gray-200 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                        <i class="fas fa-exclamation-triangle" style="color: #ef4444"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Thibitisha Ufutaji</h3>
                        <p class="text-xs text-gray-500">Hatua hii haiwezi kubatilika</p>
                    </div>
                </div>
                <button onclick="closeBulkDeleteModal()" class="rx-icon-btn rx-icon-btn-purple">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    <p class="text-sm text-yellow-700">
                        Una uhakika unataka kufuta <span id="bulkDeleteCount" class="font-semibold">0</span> ripoti?
                    </p>
                </div>
            </div>
        </div>
        <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
            <button onclick="closeBulkDeleteModal()" class="rx-btn rx-btn-secondary">Ghairi</button>
            <button onclick="confirmBulkDelete()" class="rx-btn rx-btn-danger flex items-center gap-2">
                <i class="fas fa-trash"></i> Futa
            </button>
        </div>
    </div>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchExport')?.addEventListener('input', filterRows);
    document.getElementById('filterType')?.addEventListener('change', filterRows);

    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.export-checkbox');
    const deleteBtn = document.getElementById('deleteSelectedBtn');
    const deleteCount = document.getElementById('deleteCount');

    function updateDeleteButton() {
        const checked = document.querySelectorAll('.export-checkbox:checked').length;
        deleteBtn.classList.toggle('hidden', checked === 0);
        deleteCount.textContent = checked;
    }

    selectAll?.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateDeleteButton();
    });
    checkboxes.forEach(cb => cb.addEventListener('change', updateDeleteButton));
});

function filterRows() {
    const search = (document.getElementById('searchExport')?.value || '').toLowerCase();
    const type = (document.getElementById('filterType')?.value || '').toLowerCase();
    document.querySelectorAll('.export-row').forEach(row => {
        const match = (row.dataset.filename || '').includes(search) ||
                      (row.dataset.type || '').includes(search) ||
                      (row.dataset.description || '').includes(search);
        const typeMatch = type === '' || (row.dataset.type || '') === type;
        row.style.display = match && typeMatch ? '' : 'none';
    });
}

function generateReport(period) {
    const btn = document.getElementById('btn-' + period);
    const btnText = btn.querySelector('.btn-text');
    const originalText = btnText.textContent;

    btn.disabled = true;
    btnText.textContent = 'Inatengeneza...';
    btn.querySelector('i').className = 'fas fa-spinner fa-spin';

    fetch('{{ route("reports.quick-export") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            type: 'mapato_matumizi',
            period: period,
            format: 'pdf',
            include_logo: true,
            include_header: true
        })
    })
    .then(response => {
        const ct = response.headers.get('content-type');
        if (ct && ct.includes('application/json')) {
            return response.json();
        }
        // It's a file download (non-JSON response)
        return response.blob().then(blob => ({
            _fileDownload: true,
            _blob: blob,
            _cd: response.headers.get('content-disposition') || ''
        }));
    })
    .then(data => {
        if (data._fileDownload) {
            // Direct file download - save it and trigger download
            const url = URL.createObjectURL(data._blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            // Reload to show in table
            setTimeout(() => location.reload(), 1000);
        } else if (data.success) {
            if (data.download_url && data.download_url !== '#') {
                window.location.href = data.download_url;
            }
            setTimeout(() => location.reload(), 1000);
        } else {
            alert('Hitilafu: ' + (data.message || 'Imeshindwa kutengeneza ripoti'));
            resetBtn(btn, btnText, originalText);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hitilafu ya mtandao. Tafadhali jaribu tena.');
        resetBtn(btn, btnText, originalText);
    });
}

function resetBtn(btn, btnText, originalText) {
    btn.disabled = false;
    btnText.textContent = originalText;
    btn.querySelector('i').className = 'fas fa-file-pdf';
}

async function deleteExport(id) {
    if (!confirm('Una uhakika unataka kufuta ripoti hii?')) return;
    fetch('{{ url("panel/export-excel/delete") }}/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            setTimeout(() => location.reload(), 300);
        } else {
            alert(data.message || 'Hitilafu');
        }
    });
}

function openBulkDeleteModal() {
    const count = document.querySelectorAll('.export-checkbox:checked').length;
    if (count === 0) return;
    document.getElementById('bulkDeleteCount').textContent = count;
    document.getElementById('bulkDeleteModal').classList.remove('hidden');
}

function closeBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').classList.add('hidden');
}

function confirmBulkDelete() {
    const ids = Array.from(document.querySelectorAll('.export-checkbox:checked')).map(cb => cb.value);
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("export.excel.bulk-delete") }}';
    form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="export_ids" value="' + ids.join(',') + '">';
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection