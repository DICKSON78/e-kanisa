@extends('layouts.app')

@section('title', 'Ujumbe Mpya - Mfumo wa ROC')
@section('page-title', 'Ujumbe Mpya')
@section('page-subtitle', 'Anza mazungumzo na kiongozi')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('messages.index') }}" class="p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-paper-plane" style="color: #efc120"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900 truncate">Anza Mazungumzo Mapya</h1>
            <p class="text-sm text-gray-500">Chagua kiongozi na uandike ujumbe</p>
        </div>
    </div>

    <!-- Form -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form action="{{ route('messages.send') }}" method="POST">
            @csrf

            <div class="p-6 space-y-6">
                <!-- Select Recipient -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Chagua Mpokeaji <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <select name="receiver_id" required class="rx-select">
                            <option value="">-- Chagua Kiongozi --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role->name ?? 'Kiongozi' }})</option>
                            @endforeach
                        </select>
                    </div>
                    @error('receiver_id')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message Content -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Ujumbe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-3">
                            <i class="fas fa-comment text-gray-400"></i>
                        </div>
                        <textarea name="content" rows="5" required
                            class="rx-input pl-10 @error('content') border-red-500 @enderror"
                            placeholder="Andika ujumbe wako hapa...">{{ old('content') }}</textarea>
                    </div>
                    @error('content')
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">
                        <i class="fas fa-info-circle"></i> Upeo wa herufi 2000
                    </p>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 rounded-b-2xl">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('messages.index') }}" class="rx-btn rx-btn-secondary">
                        <i class="fas fa-times"></i>
                        Ghairi
                    </a>
                    <button type="submit" class="rx-btn rx-btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        <span>Tuma Ujumbe</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Select Leaders -->
    @if($users->count() > 3)
    <div class="rx-card rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                <i class="fas fa-bolt text-xs" style="color: #efc120"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Chagua Haraka</h3>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @foreach($users->take(6) as $user)
            <button type="button" onclick="selectRecipient({{ $user->id }})"
                    class="flex items-center gap-2 p-3 bg-white border border-gray-200 rounded-xl hover:border-yellow-400 hover:bg-yellow-50 transition-all text-left">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(239,193,32,0.1)">
                    <i class="fas fa-user text-sm" style="color: #efc120"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->role->name ?? 'Kiongozi' }}</p>
                </div>
            </button>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function selectRecipient(userId) {
    document.querySelector('select[name="receiver_id"]').value = userId;
    document.querySelector('textarea[name="content"]').focus();
}
</script>
@endsection
