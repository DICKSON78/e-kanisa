@extends('layouts.app')

@section('title', 'Ingizo Jipya la Kitabu - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('accounting.journal.index') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-plus-circle" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">Ingizo Jipya la Kitabu</h1>
            <p class="text-sm text-gray-500">Unda ingizo jipya la hesabu</p>
        </div>
    </div>

    <form action="{{ route('accounting.journal.store') }}" method="POST" id="journalEntryForm">
        @csrf

        <!-- Section 1: Taarifa za Ingizo -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-info-circle text-xs" style="color: #efc120"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Taarifa za Ingizo</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Ingizo <span class="text-red-500">*</span></label>
                        <input type="date" name="entry_date" id="entry_date" value="{{ date('Y-m-d') }}" required class="rx-input rx-input-no-icon">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo <span class="text-red-500">*</span></label>
                        <input type="text" name="description" id="entry_description" required class="rx-input rx-input-no-icon" placeholder="Maelezo ya ingizo">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Aina ya Viungo</label>
                        <input type="text" name="reference_type" class="rx-input rx-input-no-icon" placeholder="mfano: Invoice (hiari)">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nambari ya Viungo</label>
                        <input type="text" name="reference_id" class="rx-input rx-input-no-icon" placeholder="mfano: INV-001 (hiari)">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Mistari ya Hesabu -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-list text-xs" style="color: #efc120"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Mistari ya Hesabu</h3>
                </div>
                <button type="button" onclick="addLine()" class="rx-btn rx-btn-primary rx-btn-sm">
                    <i class="fas fa-plus"></i> Ongeza Mstari
                </button>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full" id="linesTable">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-3 px-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[30%]">Hesabu <span class="text-red-500">*</span></th>
                                <th class="py-3 px-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[20%]">Debit</th>
                                <th class="py-3 px-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[20%]">Mikopo</th>
                                <th class="py-3 px-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[25%]">Maelezo ya Mstari</th>
                                <th class="py-3 px-2 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-[5%]"></th>
                            </tr>
                        </thead>
                        <tbody id="linesBody">
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-300 bg-gray-50">
                                <td class="py-3 px-2 text-sm font-bold text-gray-900">JUMLA</td>
                                <td class="py-3 px-2 text-right">
                                    <span id="totalDebit" class="text-sm font-mono font-bold text-gray-900">0.00</span>
                                </td>
                                <td class="py-3 px-2 text-right">
                                    <span id="totalCredit" class="text-sm font-mono font-bold text-gray-900">0.00</span>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <span id="balanceIndicator" class="rx-badge rx-badge-green">
                                        <i class="fas fa-check-circle mr-1"></i> Inalingana
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Balance Warning -->
                <div id="balanceWarning" class="hidden mt-4 bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Onyo:</strong> Jumla ya Debit hairasaki na jumla ya Mikopo. Ingizo lazima iwe na usawa.
                </div>
            </div>
        </div>

        <!-- Section 3: Viungo vya Ziada -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-sticky-note text-xs" style="color: #efc120"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Viungo vya Ziada</h3>
            </div>
            <div class="p-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo Mengine</label>
                    <textarea name="notes" rows="3" class="rx-input rx-input-no-icon" placeholder="Maelezo ya ziada (hiari)"></textarea>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 -mx-6 -mb-6 rounded-b-2xl flex justify-end gap-3 shadow-lg">
            <a href="{{ route('accounting.journal.index') }}" class="rx-btn rx-btn-secondary">
                <i class="fas fa-arrow-left"></i> Ghairi
            </a>
            <button type="submit" id="submitBtn" class="rx-btn rx-btn-primary" disabled>
                <i class="fas fa-save"></i> Hifadhi Rasimu
            </button>
        </div>
    </form>
</div>

@include('partials.loading-modal')
@endsection

@section('scripts')
<script>
const accounts = @json($accounts);
let lineIndex = 0;

function createAccountOptions() {
    let options = '<option value="">Chagua hesabu...</option>';
    accounts.forEach(acc => {
        options += `<option value="${acc.id}">${acc.account_code} - ${acc.name}</option>`;
    });
    return options;
}

function addLine(accountId = '', debit = '', credit = '', description = '') {
    lineIndex++;
    const tbody = document.getElementById('linesBody');
    const tr = document.createElement('tr');
    tr.id = `line-${lineIndex}`;
    tr.className = 'border-b border-gray-100 transition-colors hover:bg-gray-50/50';
    tr.innerHTML = `
        <td class="py-3 px-2">
            <select name="lines[${lineIndex}][account_id]" class="rx-select text-sm" required onchange="calculateTotals()">
                ${createAccountOptions()}
            </select>
        </td>
        <td class="py-3 px-2">
            <input type="number" name="lines[${lineIndex}][debit]" value="${debit}" step="0.01" min="0" class="rx-input rx-input-no-icon text-sm" placeholder="0.00" oninput="handleDebitInput(this); calculateTotals()">
        </td>
        <td class="py-3 px-2">
            <input type="number" name="lines[${lineIndex}][credit]" value="${credit}" step="0.01" min="0" class="rx-input rx-input-no-icon text-sm" placeholder="0.00" oninput="handleCreditInput(this); calculateTotals()">
        </td>
        <td class="py-3 px-2">
            <input type="text" name="lines[${lineIndex}][description]" value="${description}" class="rx-input rx-input-no-icon text-sm" placeholder="Maelezo ya mstari">
        </td>
        <td class="py-3 px-2 text-center">
            <button type="button" onclick="removeLine(${lineIndex})" class="rx-icon-btn rx-icon-btn-red" title="Susa mstari" ${tbody.children.length <= 2 ? 'disabled style="opacity:0.3;pointer-events:none;"' : ''}>
                <i class="fas fa-trash text-xs"></i>
            </button>
        </td>
    `;
    tbody.appendChild(tr);

    if (accountId) {
        tr.querySelector('select').value = accountId;
    }

    updateRemoveButtons();
}

function removeLine(index) {
    const line = document.getElementById(`line-${index}`);
    if (line) {
        line.remove();
        calculateTotals();
        updateRemoveButtons();
    }
}

function updateRemoveButtons() {
    const rows = document.querySelectorAll('#linesBody tr');
    rows.forEach((row, i) => {
        const btn = row.querySelector('.rx-icon-btn-red');
        if (btn) {
            if (rows.length <= 2) {
                btn.disabled = true;
                btn.style.opacity = '0.3';
                btn.style.pointerEvents = 'none';
            } else {
                btn.disabled = false;
                btn.style.opacity = '';
                btn.style.pointerEvents = '';
            }
        }
    });
}

function handleDebitInput(input) {
    if (input.value && input.value !== '0') {
        const creditInput = input.closest('tr').querySelector('input[name*="[credit]"]');
        if (creditInput) creditInput.value = '';
    }
}

function handleCreditInput(input) {
    if (input.value && input.value !== '0') {
        const debitInput = input.closest('tr').querySelector('input[name*="[debit]"]');
        if (debitInput) debitInput.value = '';
    }
}

function calculateTotals() {
    let totalDebit = 0;
    let totalCredit = 0;

    document.querySelectorAll('input[name*="[debit]"]').forEach(input => {
        const val = parseFloat(input.value) || 0;
        totalDebit += val;
    });

    document.querySelectorAll('input[name*="[credit]"]').forEach(input => {
        const val = parseFloat(input.value) || 0;
        totalCredit += val;
    });

    document.getElementById('totalDebit').textContent = totalDebit.toFixed(2);
    document.getElementById('totalCredit').textContent = totalCredit.toFixed(2);

    const isBalanced = Math.abs(totalDebit - totalCredit) < 0.01 && totalDebit > 0;
    const indicator = document.getElementById('balanceIndicator');
    const warning = document.getElementById('balanceWarning');
    const submitBtn = document.getElementById('submitBtn');

    if (isBalanced) {
        indicator.className = 'rx-badge rx-badge-green';
        indicator.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Inalingana';
        warning.classList.add('hidden');
        submitBtn.disabled = false;
    } else {
        indicator.className = 'rx-badge rx-badge-red';
        indicator.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Hairasaki';
        if (totalDebit > 0 || totalCredit > 0) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
        submitBtn.disabled = true;
    }
}

// Start with 2 empty lines
addLine();
addLine();

// Flash messages
@if(session('success'))
    showNotification('{{ session("success") }}', 'success');
@endif
@if(session('error'))
    showNotification('{{ session("error") }}', 'error');
@endif
</script>
@endsection
