@extends('layouts.app')

@section('title', $class->name . ' - Mfumo wa E-Kanisa')
@section('page-title', $class->name)
@section('page-subtitle', 'Taarifa za darasa la Sunday School')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('children.index') }}" class="p-2 text-gray-400 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1);">
                <i class="fas fa-chalkboard" style="color: #efc120;"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $class->name }}</h1>
                <p class="text-sm text-gray-500">Taarifa kamili za darasa na wanafunzi wake</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('children.edit', $class->id) }}" class="rx-btn rx-btn-primary">
                <i class="fas fa-edit"></i>
                Hariri
            </a>
            <form action="{{ route('children.destroy', $class->id) }}" method="POST"
                  onsubmit="return confirm('Je, una uhakika unataka kufuta darasa hili?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="rx-btn rx-btn-danger">
                    <i class="fas fa-trash"></i>
                    Futa
                </button>
            </form>
        </div>
    </div>

    <!-- Profile Banner -->
    <div class="rx-card rounded-2xl overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-purple-900 to-purple-700"></div>
        <div class="px-6 pb-6 -mt-10">
            <div class="flex items-end gap-4">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center border-4 border-white bg-white shadow-md">
                    <i class="fas fa-chalkboard text-2xl" style="color: #360958;"></i>
                </div>
                <div class="flex-1 pb-1">
                    <h2 class="text-xl font-bold text-gray-900">{{ $class->name }}</h2>
                    <p class="text-sm text-gray-500">Sunday School Darasa</p>
                </div>
                <div>
                    @if($class->is_active)
                        <span class="rx-badge rx-badge-green"><i class="fas fa-check-circle mr-1"></i> Inafanya kazi</span>
                    @else
                        <span class="rx-badge rx-badge-gray"><i class="fas fa-pause-circle mr-1"></i> Haifanyi kazi</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Class Details Card -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,193,32,0.1);">
                            <i class="fas fa-info-circle" style="color: #efc120;"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Taarifa za Darasa</h3>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Hali</span>
                        @if($class->is_active)
                            <span class="rx-badge rx-badge-green"><i class="fas fa-check-circle mr-1"></i> Inafanya kazi</span>
                        @else
                            <span class="rx-badge rx-badge-red"><i class="fas fa-times-circle mr-1"></i> Haifanyi kazi</span>
                        @endif
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <div class="text-sm text-gray-500 mb-1">Umri</div>
                        <div class="font-medium text-gray-900">
                            <i class="fas fa-calendar-alt mr-2" style="color: #16a34a;"></i>
                            {{ $class->age_min ?? 0 }} - {{ $class->age_max ?? 18 }} miaka
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <div class="text-sm text-gray-500 mb-1">Wanafunzi</div>
                        <div class="text-2xl font-bold" style="color: #2563eb;">
                            <i class="fas fa-child mr-2"></i>
                            {{ $students->total() }}
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <div class="text-sm text-gray-500 mb-1">Walimu</div>
                        <div class="text-2xl font-bold" style="color: #7c3aed;">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>
                            {{ $teachers->total() }}
                        </div>
                    </div>

                    @if($class->description)
                    <div class="border-t border-gray-100 pt-4">
                        <div class="text-sm text-gray-500 mb-1">Maelezo</div>
                        <div class="text-gray-900 text-sm">{{ $class->description }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Add Student Form -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(37,99,235,0.08);">
                            <i class="fas fa-user-plus" style="color: #2563eb;"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Ongeza Mwanafunzi</h3>
                    </div>
                </div>
                <div class="p-5">
                    <form action="{{ route('children.add-student', $class->id) }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-3">
                            <div>
                                <label for="member_id_student" class="block text-sm font-medium text-gray-700 mb-2">
                                    Chagua Mwanachama
                                </label>
                                <select name="member_id" id="member_id_student" class="rx-select @error('member_id') border-red-500 @enderror">
                                    <option value="">-- Chagua Mwanachama --</option>
                                    @foreach($all_members as $member)
                                        <option value="{{ $member->id }}">{{ $member->full_name }} ({{ $member->member_number }})</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="rx-btn rx-btn-primary w-full justify-center">
                                <i class="fas fa-plus"></i>
                                Ongeza Mwanafunzi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Teacher Form -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(124,58,237,0.08);">
                            <i class="fas fa-user-plus" style="color: #7c3aed;"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Ongeza Mwalimu</h3>
                    </div>
                </div>
                <div class="p-5">
                    <form action="{{ route('children.add-teacher', $class->id) }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-3">
                            <div>
                                <label for="member_id_teacher" class="block text-sm font-medium text-gray-700 mb-2">
                                    Chagua Mwanachama
                                </label>
                                <select name="member_id" id="member_id_teacher" class="rx-select @error('member_id') border-red-500 @enderror">
                                    <option value="">-- Chagua Mwanachama --</option>
                                    @foreach($all_members as $member)
                                        <option value="{{ $member->id }}">{{ $member->full_name }} ({{ $member->member_number }})</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="rx-btn rx-btn-primary w-full justify-center" style="background: #7c3aed;">
                                <i class="fas fa-plus"></i>
                                Ongeza Mwalimu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Students -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(37,99,235,0.08);">
                            <i class="fas fa-child" style="color: #2563eb;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Wanafunzi wa Darasa</h3>
                            <p class="text-xs text-gray-500">{{ $students->total() }} wanafunzi</p>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    @if($students->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="rx-table">
                                <thead>
                                    <tr>
                                        <th>Mwanafunzi</th>
                                        <th>Nambari</th>
                                        <th>Simu</th>
                                        <th style="text-align: right;">Vitendo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <div class="flex items-center">
                                                <div class="w-9 h-9 rounded-lg flex items-center justify-center mr-3" style="background: rgba(37,99,235,0.08);">
                                                    <i class="fas fa-child text-sm" style="color: #2563eb;"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $student->full_name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-sm text-gray-900">{{ $student->member_number }}</td>
                                        <td class="text-sm text-gray-900">{{ $student->phone ?? '-' }}</td>
                                        <td style="text-align: right;">
                                            <form action="{{ route('children.remove-student', [$class->id, $student->id]) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Je, una uhakika unataka kumwondoa mwanafunzi huyu?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rx-icon-btn rx-icon-btn-red" title="Ondoa">
                                                    <i class="fas fa-user-minus text-xs"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($students->hasPages())
                        <div class="mt-5 pt-5 border-t border-gray-200">
                            {{ $students->links() }}
                        </div>
                        @endif
                    @else
                        <div class="rx-empty">
                            <div class="rx-empty-icon">
                                <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hakuna Wanafunzi</h3>
                            <p class="text-sm text-gray-500">Darasa hili halina wanafunzi bado. Ongeza mwanafunzi wa kwanza.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Teachers -->
            <div class="rx-card rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(124,58,237,0.08);">
                            <i class="fas fa-chalkboard-teacher" style="color: #7c3aed;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Walimu wa Darasa</h3>
                            <p class="text-xs text-gray-500">{{ $teachers->total() }} walimu</p>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    @if($teachers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="rx-table">
                                <thead>
                                    <tr>
                                        <th>Mwalimu</th>
                                        <th>Nambari</th>
                                        <th>Simu</th>
                                        <th style="text-align: right;">Vitendo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $teacher)
                                    <tr>
                                        <td>
                                            <div class="flex items-center">
                                                <div class="w-9 h-9 rounded-lg flex items-center justify-center mr-3" style="background: rgba(124,58,237,0.08);">
                                                    <i class="fas fa-chalkboard-teacher text-sm" style="color: #7c3aed;"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $teacher->full_name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $teacher->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-sm text-gray-900">{{ $teacher->member_number }}</td>
                                        <td class="text-sm text-gray-900">{{ $teacher->phone ?? '-' }}</td>
                                        <td style="text-align: right;">
                                            <form action="{{ route('children.remove-teacher', [$class->id, $teacher->id]) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Je, una uhakika unataka kumwondoa mwalimu huyu?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rx-icon-btn rx-icon-btn-red" title="Ondoa">
                                                    <i class="fas fa-user-minus text-xs"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($teachers->hasPages())
                        <div class="mt-5 pt-5 border-t border-gray-200">
                            {{ $teachers->links() }}
                        </div>
                        @endif
                    @else
                        <div class="rx-empty">
                            <div class="rx-empty-icon">
                                <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hakuna Walimu</h3>
                            <p class="text-sm text-gray-500">Darasa hili halina walimu bado. Ongeza mwalimu wa kwanza.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
