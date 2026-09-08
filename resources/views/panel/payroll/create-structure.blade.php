@extends('layouts.app')

@section('title', 'Muundo Mpya wa Mshahara - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3 mb-2 pt-2 pb-2">
        <a href="{{ route('payroll.salary-structures') }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-user-plus" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Muundo Mpya wa Mshahara</h1>
            <p class="text-sm text-gray-500">Weka muundo wa mshahara wa mwanachama</p>
        </div>
    </div>

    <form method="POST" action="{{ route('payroll.store-structure') }}">
        @csrf

        <!-- Section 1: Taarifa za Mwanachama -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-user" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Mwanachama</h3>
                        <p class="text-sm text-gray-500">Chagua mwanachama</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="member_id" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mwanachama <span class="text-red-500">*</span>
                        </label>
                        <select id="member_id" name="member_id" required class="rx-select @error('member_id') border-red-500 @enderror">
                            <option value="">Chagua Mwanachama</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_number }} - {{ $member->first_name }} {{ $member->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Mshahara -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-money-bill-wave" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mshahara</h3>
                        <p class="text-sm text-gray-500">Weka kiasi cha mshahara na allowances</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="basic_salary" class="block text-sm font-semibold text-gray-900 mb-2">
                            Mshahara wa Msingi (TSh) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="basic_salary" name="basic_salary" value="{{ old('basic_salary') }}" step="1" min="0" required
                               class="rx-input rx-input-no-icon @error('basic_salary') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('basic_salary')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="allowance_housing" class="block text-sm font-semibold text-gray-900 mb-2">Allowance ya Nyumba (TSh)</label>
                        <input type="number" id="allowance_housing" name="allowance_housing" value="{{ old('allowance_housing') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('allowance_housing') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('allowance_housing')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="allowance_transport" class="block text-sm font-semibold text-gray-900 mb-2">Allowance ya Usafiri (TSh)</label>
                        <input type="number" id="allowance_transport" name="allowance_transport" value="{{ old('allowance_transport') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('allowance_transport') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('allowance_transport')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="allowance_food" class="block text-sm font-semibold text-gray-900 mb-2">Allowance ya Chakula (TSh)</label>
                        <input type="number" id="allowance_food" name="allowance_food" value="{{ old('allowance_food') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('allowance_food') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('allowance_food')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="allowance_other" class="block text-sm font-semibold text-gray-900 mb-2">Allowance Nyingine (TSh)</label>
                        <input type="number" id="allowance_other" name="allowance_other" value="{{ old('allowance_other') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('allowance_other') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('allowance_other')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Kodi -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-percentage" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Kata</h3>
                        <p class="text-sm text-gray-500">Viwango vya kodi na michango</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nssf_employee" class="block text-sm font-semibold text-gray-900 mb-2">NSSF (TSh)</label>
                        <input type="number" id="nssf_employee" name="nssf_employee" value="{{ old('nssf_employee') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('nssf_employee') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('nssf_employee')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nhif_amount" class="block text-sm font-semibold text-gray-900 mb-2">NHIF (TSh)</label>
                        <input type="number" id="nhif_amount" name="nhif_amount" value="{{ old('nhif_amount') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('nhif_amount') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('nhif_amount')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="paye_amount" class="block text-sm font-semibold text-gray-900 mb-2">PAYE (TSh)</label>
                        <input type="number" id="paye_amount" name="paye_amount" value="{{ old('paye_amount') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('paye_amount') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('paye_amount')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="other_deductions" class="block text-sm font-semibold text-gray-900 mb-2">Kodi Nyingine (TSh)</label>
                        <input type="number" id="other_deductions" name="other_deductions" value="{{ old('other_deductions') }}" step="1" min="0"
                               class="rx-input rx-input-no-icon @error('other_deductions') border-red-500 @enderror" placeholder="0" oninput="calculateSummary()">
                        @error('other_deductions')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Njia ya Malipo -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-credit-card" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Njia ya Malipo</h3>
                        <p class="text-sm text-gray-500">Chagua jinsi ya kulipa mwanachama</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="payment_method" class="block text-sm font-semibold text-gray-900 mb-2">
                            Njia ya Malipo <span class="text-red-500">*</span>
                        </label>
                        <select id="payment_method" name="payment_method" required class="rx-select @error('payment_method') border-red-500 @enderror" onchange="togglePaymentFields()">
                            <option value="">Chagua Njia</option>
                            <option value="Benki" {{ old('payment_method') == 'Benki' ? 'selected' : '' }}>Benki</option>
                            <option value="Msimamizi" {{ old('payment_method') == 'Msimamizi' ? 'selected' : '' }}>Msimamizi</option>
                            <option value="Pesa ya Simu" {{ old('payment_method') == 'Pesa ya Simu' ? 'selected' : '' }}>Pesa ya Simu</option>
                        </select>
                        @error('payment_method')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="bankFields" style="{{ old('payment_method') != 'Benki' ? 'display:none' : '' }}">
                        <label for="bank_name" class="block text-sm font-semibold text-gray-900 mb-2">Jina la Benki</label>
                        <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                               class="rx-input rx-input-no-icon @error('bank_name') border-red-500 @enderror" placeholder="Weka jina la benki...">
                        @error('bank_name')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="accountFields" style="{{ old('payment_method') != 'Benki' ? 'display:none' : '' }}">
                        <label for="bank_account" class="block text-sm font-semibold text-gray-900 mb-2">Akaunti ya Benki</label>
                        <input type="text" id="bank_account" name="bank_account" value="{{ old('bank_account') }}"
                               class="rx-input rx-input-no-icon @error('bank_account') border-red-500 @enderror" placeholder="Weka namba ya akaunti...">
                        @error('bank_account')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="mobileFields" style="{{ old('payment_method') != 'Pesa ya Simu' ? 'display:none' : '' }}">
                        <label for="mobile_number" class="block text-sm font-semibold text-gray-900 mb-2">Namba ya Simu</label>
                        <input type="text" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}"
                               class="rx-input rx-input-no-icon @error('mobile_number') border-red-500 @enderror" placeholder="Weka namba ya simu...">
                        @error('mobile_number')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Tarehe -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Tarehe</h3>
                        <p class="text-sm text-gray-500">Tarehe ya kuanza kutumika</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="effective_date" class="block text-sm font-semibold text-gray-900 mb-2">
                            Tarehe ya Kuanza <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="effective_date" name="effective_date" value="{{ old('effective_date', date('Y-m-d')) }}" required
                               class="rx-input rx-input-no-icon @error('effective_date') border-red-500 @enderror">
                        @error('effective_date')
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="rx-card rounded-2xl overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calculator" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Muhtasari</h3>
                        <p class="text-sm text-gray-500">Muhtasari wa hesabu za mshahara</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 rounded-xl bg-blue-50">
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-2">Mapato (GROSS)</p>
                        <p class="text-2xl font-bold font-mono" style="color: #360958" id="summaryGross">0 TSh</p>
                    </div>
                    <div class="p-4 rounded-xl bg-red-50">
                        <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">Jumla ya Kodi</p>
                        <p class="text-2xl font-bold font-mono text-red-600" id="summaryDeductions">0 TSh</p>
                    </div>
                    <div class="p-4 rounded-xl bg-green-50">
                        <p class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-2">Mshahara wa Mikono (NET)</p>
                        <p class="text-2xl font-bold font-mono" style="color: #16a34a" id="summaryNet">0 TSh</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
            <a href="{{ route('payroll.salary-structures') }}" class="rx-btn rx-btn-secondary">
                <i class="fas fa-times"></i> Ghairi
            </a>
            <button type="submit" class="rx-btn rx-btn-primary">
                <i class="fas fa-save"></i> Hifadhi Muundo
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function formatCurrency(num) {
    return new Intl.NumberFormat('sw-TZ').format(num) + ' TSh';
}

function getVal(id) {
    return parseFloat(document.getElementById(id).value) || 0;
}

function calculateSummary() {
    var basic = getVal('basic_salary');
    var allowances = getVal('allowance_housing') + getVal('allowance_transport') + getVal('allowance_food') + getVal('allowance_other');
    var gross = basic + allowances;
    var deductions = getVal('nssf_employee') + getVal('nhif_amount') + getVal('paye_amount') + getVal('other_deductions');
    var net = gross - deductions;

    document.getElementById('summaryGross').textContent = formatCurrency(gross);
    document.getElementById('summaryDeductions').textContent = formatCurrency(deductions);
    document.getElementById('summaryNet').textContent = formatCurrency(net);
}

function togglePaymentFields() {
    var method = document.getElementById('payment_method').value;
    document.getElementById('bankFields').style.display = method === 'Benki' ? '' : 'none';
    document.getElementById('accountFields').style.display = method === 'Benki' ? '' : 'none';
    document.getElementById('mobileFields').style.display = method === 'Pesa ya Simu' ? '' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    togglePaymentFields();
    calculateSummary();
});
</script>
@endsection
