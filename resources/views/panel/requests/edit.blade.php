@extends('layouts.app')

@section('title', 'Hariri Ombi - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Back Button + Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('requests.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Rudi">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-edit" style="color: #efc120"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Hariri Ombi</h1>
                <p class="text-sm text-gray-500">{{ $request->request_number }} - Sasisha taarifa za ombi</p>
            </div>
        </div>
    </div>

    <!-- Warning -->
    @if($request->status !== 'Inasubiri')
    <div class="rx-card rounded-xl p-4 border-l-4" style="border-left-color: #ca8a04">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(202,138,4,0.1)">
                <i class="fas fa-exclamation-triangle text-sm" style="color: #ca8a04"></i>
            </div>
            <p class="text-sm text-gray-700">
                <strong>Onyo:</strong> Ombi hili haliruhusiwi kuhaririwa kwa sababu hali yake ni {{ $request->status }}
            </p>
        </div>
    </div>
    @endif

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form method="POST" action="{{ route('requests.update', $request->id) }}">
            @csrf
            @method('PUT')

            <!-- Taarifa za Ombi -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-alt" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Taarifa za Ombi</h3>
                        <p class="text-xs text-gray-500">Sasisha taarifa za kimsingi za ombi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Namba ya Ombi</label>
                        <input type="text" value="{{ $request->request_number }}" disabled class="rx-input rx-input-no-icon bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kichwa cha Ombi <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="text" name="title" value="{{ old('title', $request->title) }}" required {{ $request->status !== 'Inasubiri' ? 'disabled' : '' }} placeholder="Kwa mfano: Ukarabati wa Kanisa" class="@error('title') !border-red-500 @enderror {{ $request->status !== 'Inasubiri' ? 'bg-gray-50' : '' }}">
                        </div>
                        @error('title')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Idara <span class="text-red-500">*</span></label>
                        <select name="department" required {{ $request->status !== 'Inasubiri' ? 'disabled' : '' }} class="rx-select @error('department') !border-red-500 @enderror {{ $request->status !== 'Inasubiri' ? 'bg-gray-50' : '' }}">
                            <option value="">Chagua idara</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ old('department', $request->department) == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('department')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kiasi Kinachoombwa (TSh) <span class="text-red-500">*</span></label>
                        <div class="rx-search">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                            <input type="number" name="amount_requested" value="{{ old('amount_requested', $request->amount_requested) }}" step="0.01" min="0" required {{ $request->status !== 'Inasubiri' ? 'disabled' : '' }} placeholder="0.00" class="@error('amount_requested') !border-red-500 @enderror {{ $request->status !== 'Inasubiri' ? 'bg-gray-50' : '' }}">
                        </div>
                        @error('amount_requested')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tarehe ya Ombi <span class="text-red-500">*</span></label>
                        <input type="date" name="requested_date" value="{{ old('requested_date', $request->requested_date->format('Y-m-d')) }}" required {{ $request->status !== 'Inasubiri' ? 'disabled' : '' }} class="rx-input rx-input-no-icon @error('requested_date') !border-red-500 @enderror {{ $request->status !== 'Inasubiri' ? 'bg-gray-50' : '' }}">
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
                    <textarea name="description" rows="5" required {{ $request->status !== 'Inasubiri' ? 'disabled' : '' }} class="rx-input rx-input-no-icon @error('description') !border-red-500 @enderror {{ $request->status !== 'Inasubiri' ? 'bg-gray-50' : '' }}" placeholder="Eleza kwa undani kuhusu ombi lako...">{{ old('description', $request->description) }}</textarea>
                    @error('description')<p class="mt-1.5 text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('requests.show', $request->id) }}" class="rx-btn rx-btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Ghairi</span>
                </a>
                @if($request->status === 'Inasubiri')
                <button type="submit" class="rx-btn rx-btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Sasisha Ombi</span>
                </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
