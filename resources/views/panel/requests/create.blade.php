@extends('layouts.app')

@section('title', 'Omba Fedha - Mfumo wa ROC')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('requests.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-plus-circle" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Omba Fedha</h1>
                <p class="text-sm text-gray-500">Wasilisha ombi jipya la fedha</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('requests.store') }}">
            @csrf

            <!-- Taarifa za Ombi -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Ombi</h3>
                        <p class="text-xs text-gray-500">Ingiza taarifa za kimsingi za ombi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Namba ya Ombi</label>
                        <input type="text" value="{{ $nextRequestNumber }}" disabled class="rx-input rx-input-no-icon bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kichwa cha Ombi <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Kwa mfano: Ukarabati wa Kanisa" class="@error('title') !border-red-500 @enderror">
                        </div>
                        @error('title')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Idara <span class="text-red-500">*</span></label>
                        <select name="department" required class="rx-select @error('department') !border-red-500 @enderror">
                            <option value="">Chagua idara</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('department')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi Kinachoombwa (TSh) <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="number" name="amount_requested" value="{{ old('amount_requested') }}" step="0.01" min="0" required placeholder="0.00" class="@error('amount_requested') !border-red-500 @enderror">
                        </div>
                        @error('amount_requested')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Ombi <span class="text-red-500">*</span></label>
                        <input type="date" name="requested_date" value="{{ old('requested_date', date('Y-m-d')) }}" required class="rx-input rx-input-no-icon @error('requested_date') !border-red-500 @enderror">
                        @error('requested_date')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Maelezo -->
            <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Maelezo ya Ombi</h3>
                        <p class="text-xs text-gray-500">Eleza kwa undani kuhusu ombi lako</p>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Maelezo <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required class="rx-input rx-input-no-icon @error('description') !border-red-500 @enderror" placeholder="Eleza kwa undani kuhusu ombi lako...">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('requests.index') }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
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
</div>
@endsection
