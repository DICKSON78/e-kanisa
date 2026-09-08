@extends('layouts.app')
@section('title', 'Hariri Bajeti - Mfumo wa E-Kanisa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('budgets.show', $budget->id) }}" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-lg hover:bg-gray-100 hover:text-gray-600 transition-all duration-200">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
            <i class="fas fa-edit" style="color: #efc120"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hariri Bajeti</h1>
            <p class="text-sm text-gray-500">Badilisha taarifa za bajeti {{ $budget->budget_number }}</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Taarifa za Bajeti -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-file-invoice-dollar" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Taarifa za Bajeti</h3>
                        <p class="text-sm text-gray-500">Badilisha taarifa za bajeti hii</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kichwa cha Bajeti <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $budget->title) }}" required
                               class="rx-input rx-input-no-icon @error('title') border-red-500 @enderror">
                        @error('title')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Maelezo</label>
                        <textarea name="description" rows="3"
                                  class="rx-input rx-input-no-icon @error('description') border-red-500 @enderror">{{ old('description', $budget->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Kiasi Kilichopangwa (TZS) <span class="text-red-500">*</span></label>
                        <input type="number" name="budgeted_amount" value="{{ old('budgeted_amount', $budget->budgeted_amount) }}" required min="0" step="0.01"
                               class="rx-input rx-input-no-icon @error('budgeted_amount') border-red-500 @enderror">
                        @error('budgeted_amount')<p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Hali <span class="text-red-500">*</span></label>
                        <select name="status" class="rx-select @error('status') border-red-500 @enderror">
                            <option value="Active" {{ $budget->status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Completed" {{ $budget->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $budget->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Maelezo ya Ziada -->
            <div class="p-6 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1)">
                        <i class="fas fa-info-circle" style="color: #efc120"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Maelezo ya Ziada</h3>
                        <p class="text-sm text-gray-500">Taarifa zingine muhimu (hiari)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Maelezo ya Ziada</label>
                        <textarea name="notes" rows="2"
                                  class="rx-input rx-input-no-icon @error('notes') border-red-500 @enderror">{{ old('notes', $budget->notes) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white px-6 py-5 border-t border-gray-200 flex justify-end space-x-4 rounded-b-2xl">
                <a href="{{ route('budgets.show', $budget->id) }}" class="rx-btn rx-btn-secondary"><i class="fas fa-times"></i> Ghairi</a>
                <button type="submit" class="rx-btn rx-btn-primary"><i class="fas fa-save"></i> Sasisha Bajeti</button>
            </div>
        </form>
    </div>
</div>
@endsection
