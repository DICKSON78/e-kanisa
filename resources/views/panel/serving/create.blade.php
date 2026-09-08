@extends('layouts.app')

@section('title', 'Ongeza Ratiba - Mfumo wa ROC')
@section('page-title', 'Ratiba Mpya')
@section('page-subtitle', 'Ongeza ratiba ya kuhudumu kanisani')

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('serving.index') }}" class="rx-btn rx-btn-secondary rx-btn-sm">
            <i class="fas fa-arrow-left text-xs"></i> Rudi
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-calendar-plus" style="color: #360958"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Ongeza Ratiba Mpya</h1>
            <p class="text-sm text-gray-500">Jaza taarifa za ratiba ya kuhudumu</p>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card">
        <form method="POST" action="{{ route('serving.store') }}">
            @csrf

            <!-- Taarifa za Ratiba -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-calendar-check" style="color: #360958"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Taarifa za Ratiba</h3>
                        <p class="text-xs text-gray-500">Jaza taarifa za kimsingi za ratiba</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Kichwa cha Ratiba <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required class="rx-input rx-input-no-icon @error('title') border-red-500 @enderror" placeholder="Kichwa cha ratiba">
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Maelezo</label>
                        <textarea id="description" name="description" rows="3" class="rx-input rx-input-no-icon @error('description') border-red-500 @enderror" placeholder="Maelezo ya ratiba">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Tarehe ya Ratiba <span class="text-red-500">*</span></label>
                        <input type="date" id="schedule_date" name="schedule_date" value="{{ old('schedule_date') }}" required class="rx-input rx-input-no-icon @error('schedule_date') border-red-500 @enderror">
                        @error('schedule_date')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Aina ya Huduma <span class="text-red-500">*</span></label>
                        <select id="service_type" name="service_type" required class="rx-select @error('service_type') border-red-500 @enderror">
                            <option value="">Chagua Aina ya Huduma</option>
                            <option value="Ibada Kuu" {{ old('service_type') === 'Ibada Kuu' ? 'selected' : '' }}>Ibada Kuu</option>
                            <option value="Ibada ya Jumapili" {{ old('service_type') === 'Ibada ya Jumapili' ? 'selected' : '' }}>Ibada ya Jumapili</option>
                            <option value="Ibada ya Alhamisi" {{ old('service_type') === 'Ibada ya Alhamisi' ? 'selected' : '' }}>Ibada ya Alhamisi</option>
                            <option value="Kikao" {{ old('service_type') === 'Kikao' ? 'selected' : '' }}>Kikao</option>
                            <option value="Nyingine" {{ old('service_type') === 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                        </select>
                        @error('service_type')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Waliopangwa Kuhudumu -->
            <div class="p-6 bg-gray-50/50 border-b border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-users" style="color: #360958"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Waliopangwa Kuhudumu</h3>
                            <p class="text-xs text-gray-500">Ongeza waumini watakaohudumu</p>
                        </div>
                    </div>
                    <button type="button" id="addAssignment" class="rx-btn rx-btn-primary rx-btn-sm">
                        <i class="fas fa-plus text-xs"></i> Ongeza Mtu
                    </button>
                </div>
                <div id="assignmentsContainer" class="space-y-3">
                    <div class="assignment-row rx-card p-4" data-index="0">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Muumini *</label>
                                <select name="assignments[0][member_id]" required class="rx-select text-xs">
                                    <option value="">Chagua Muumini</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Jukumu *</label>
                                <select name="assignments[0][role]" required class="rx-select text-xs">
                                    <option value="">Chagua Jukumu</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Nafasi</label>
                                <input type="text" name="assignments[0][position]" placeholder="mfano: Kwanza" class="rx-input rx-input-no-icon text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Maelezo</label>
                                <input type="text" name="assignments[0][notes]" placeholder="Maelezo ya ziada" class="rx-input rx-input-no-icon text-xs">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="remove-assignment rx-icon-btn rx-icon-btn-red" title="Ondoa">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
                <a href="{{ route('serving.index') }}" class="rx-btn rx-btn-secondary">
                    <i class="fas fa-times text-xs"></i> Ghairi
                </a>
                <button type="submit" class="rx-btn rx-btn-primary">
                    <i class="fas fa-save text-xs"></i> Hifadhi Ratiba
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let assignmentIndex = 1;
    const container = document.getElementById('assignmentsContainer');
    const addButton = document.getElementById('addAssignment');
    const membersOptions = `{!! json_encode($members->map(fn($m) => ['id' => $m->id, 'name' => $m->first_name . ' ' . $m->last_name])) !!}`;
    const rolesOptions = `{!! json_encode($roles) !!}`;

    addButton.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'assignment-row rx-card p-4';
        row.dataset.index = assignmentIndex;

        let memberSelect = '<option value="">Chagua Muumini</option>';
        membersOptions.forEach(function(m) {
            memberSelect += `<option value="${m.id}">${m.name}</option>`;
        });

        let roleSelect = '<option value="">Chagua Jukumu</option>';
        rolesOptions.forEach(function(r) {
            roleSelect += `<option value="${r}">${r}</option>`;
        });

        row.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Muumini *</label>
                    <select name="assignments[${assignmentIndex}][member_id]" required class="rx-select text-xs">
                        ${memberSelect}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Jukumu *</label>
                    <select name="assignments[${assignmentIndex}][role]" required class="rx-select text-xs">
                        ${roleSelect}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nafasi</label>
                    <input type="text" name="assignments[${assignmentIndex}][position]" placeholder="mfano: Kwanza" class="rx-input rx-input-no-icon text-xs">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Maelezo</label>
                    <input type="text" name="assignments[${assignmentIndex}][notes]" placeholder="Maelezo ya ziada" class="rx-input rx-input-no-icon text-xs">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="remove-assignment rx-icon-btn rx-icon-btn-red" title="Ondoa">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(row);
        assignmentIndex++;
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-assignment')) {
            const rows = container.querySelectorAll('.assignment-row');
            if (rows.length > 1) {
                e.target.closest('.assignment-row').remove();
            }
        }
    });
});
</script>
@endpush
@endsection
