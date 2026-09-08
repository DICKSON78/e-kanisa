@extends('layouts.app')

@section('title', 'Omba Idhini Mpya - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('approvals.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-plus-circle" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Omba Idhini Mpya</h1>
                <p class="text-sm text-gray-500">Wasilisha ombi jipya la idhini ya idara</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('approvals.store') }}">
            @csrf

            <!-- Section 1: Taarifa za Ombi -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Ombi</h3>
                        <p class="text-xs text-gray-500">Jaza taarifa za kimsingi za ombi la idhini</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Idara <span class="text-red-500">*</span></label>
                        <select name="department_id" required class="rx-select @error('department_id') !border-red-500 @enderror">
                            <option value="">Chagua Idara</option>
                            @if(isset($departments))
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('department_id')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kichwa cha Ombi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Kwa mfano: Ukarabati wa Ofisi" class="rx-input rx-input-no-icon @error('title') !border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi Kinachoombwa (TSh) <span class="text-red-500">*</span></label>
                        <input type="number" name="amount_requested" value="{{ old('amount_requested') }}" step="0.01" min="1" required placeholder="0.00" class="rx-input rx-input-no-icon @error('amount_requested') !border-red-500 @enderror">
                        @error('amount_requested')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Lengo la Matumizi <span class="text-red-500">*</span></label>
                        <input type="text" name="expense_purpose" value="{{ old('expense_purpose') }}" required placeholder="Kwa mfano: Kununua vifaa vya ofisi" class="rx-input rx-input-no-icon @error('expense_purpose') !border-red-500 @enderror">
                        @error('expense_purpose')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kipaumbele <span class="text-red-500">*</span></label>
                        <select name="priority" required class="rx-select @error('priority') !border-red-500 @enderror">
                            <option value="">Chagua Kipaumbele</option>
                            <option value="Ya Kawaida" {{ old('priority') == 'Ya Kawaida' ? 'selected' : '' }}>Ya Kawaida</option>
                            <option value="Ya Juu" {{ old('priority') == 'Ya Juu' ? 'selected' : '' }}>Ya Juu</option>
                            <option value="Dharura" {{ old('priority') == 'Dharura' ? 'selected' : '' }}>Dharura</option>
                        </select>
                        @error('priority')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Ombi <span class="text-red-500">*</span></label>
                        <input type="date" name="requested_date" value="{{ old('requested_date', date('Y-m-d')) }}" required class="rx-input rx-input-no-icon @error('requested_date') !border-red-500 @enderror">
                        @error('requested_date')
                            <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Maelezo -->
            <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo</h3>
                        <p class="text-xs text-gray-500">Eleza kwa undani kuhusu ombi lako</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo Kamili</label>
                    <textarea name="description" rows="5" class="rx-input rx-input-no-icon @error('description') !border-red-500 @enderror" placeholder="Eleza kwa undani kuhusu ombi lako, sababu za kuhitaji fedha hizi, na jinsi fedha zitatumika...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('approvals.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Wasilisha Ombi</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Help Text -->
    <div class="rx-card rounded-xl p-4">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(59,130,246,0.1)">
                <i class="fas fa-info-circle text-sm" style="color: #3b82f6"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">
                    <strong>Maelekezo:</strong> Baada ya kuwasilisha ombi, litasubiri idhini kutoka kwa watumishi husika kulingana na kiwango cha fedha. Utapokea taarifa kupitia mfumo.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection