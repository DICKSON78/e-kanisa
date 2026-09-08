<!-- Table Header -->
<div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
        <i class="fas fa-list" style="color: #efc120"></i>
        Orodha ya Madarasa
        <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full font-medium">
            {{ $classes->total() }} total
        </span>
    </h3>
    <p class="text-sm text-gray-500">
        Kuonyesha {{ $classes->firstItem() }} - {{ $classes->lastItem() }} ya {{ $classes->total() }}
    </p>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="rx-table">
        <thead>
            <tr>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-hashtag text-xs" style="color: #efc120"></i>
                        <span>Namba</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-chalkboard text-xs" style="color: #efc120"></i>
                        <span>Jina la Darasa</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-align-left text-xs" style="color: #efc120"></i>
                        <span>Maelezo</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-alt text-xs" style="color: #efc120"></i>
                        <span>Umri</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-child text-xs" style="color: #efc120"></i>
                        <span>Wanafunzi</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-chalkboard-teacher text-xs" style="color: #efc120"></i>
                        <span>Walimu</span>
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-circle text-xs" style="color: #efc120"></i>
                        <span>Hali</span>
                    </div>
                </th>
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <th class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <i class="fas fa-cogs text-xs" style="color: #efc120"></i>
                        <span>Vitendo</span>
                    </div>
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $index => $class)
            <tr class="transition-colors"
                data-name="{{ strtolower($class->name) }}"
                data-description="{{ strtolower($class->description ?? '') }}"
                data-status="{{ $class->is_active ? 'active' : 'inactive' }}">

                <!-- Number -->
                <td>
                    <span class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-2 py-1 rounded-md">{{ $loop->iteration + ($classes->currentPage() - 1) * $classes->perPage() }}</span>
                </td>

                <!-- Class Name -->
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full" style="background: rgba(239,193,32,0.1)">
                            <i class="fas fa-chalkboard text-xs" style="color: #efc120"></i>
                        </div>
                        <a href="{{ route('children.show', $class->id) }}" class="text-sm font-medium hover:underline" style="color: #360958">{{ $class->name }}</a>
                    </div>
                </td>

                <!-- Description -->
                <td>
                    <div class="text-sm text-gray-600 max-w-[200px] truncate" title="{{ $class->description ?? '' }}">
                        {{ $class->description ?? '-' }}
                    </div>
                </td>

                <!-- Age Range -->
                <td>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                        {{ $class->age_min ?? 0 }} - {{ $class->age_max ?? 18 }} miaka
                    </div>
                </td>

                <!-- Students -->
                <td>
                    <span class="rx-badge rx-badge-blue">
                        <i class="fas fa-child mr-1"></i>{{ $class->students_count }}
                    </span>
                </td>

                <!-- Teachers -->
                <td>
                    <span class="rx-badge" style="background: rgba(124,58,237,0.1); color: #7c3aed;">
                        <i class="fas fa-chalkboard-teacher mr-1"></i>{{ $class->teachers_count }}
                    </span>
                </td>

                <!-- Status -->
                <td>
                    @if($class->is_active)
                        <span class="rx-badge rx-badge-green">
                            <i class="fas fa-check-circle mr-1"></i>Inafanya kazi
                        </span>
                    @else
                        <span class="rx-badge rx-badge-gray">
                            <i class="fas fa-pause-circle mr-1"></i>Haifanyi kazi
                        </span>
                    @endif
                </td>

                <!-- Actions -->
                @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                        <!-- View -->
                        <a href="{{ route('children.show', $class->id) }}"
                           class="rx-icon-btn rx-icon-btn-blue"
                           title="Angalia Maelezo">
                            <i class="fas fa-eye text-xs"></i>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('children.edit', $class->id) }}"
                           class="rx-icon-btn rx-icon-btn-gold"
                           title="Hariri">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>

                        <!-- Delete -->
                        <button type="button"
                                onclick="confirmAction('delete', {{ $class->id }}, '{{ addslashes($class->name) }}')"
                                class="rx-icon-btn rx-icon-btn-red"
                                title="Futa">
                            <i class="fas fa-trash text-xs"></i>
                        </button>

                        <!-- Hidden Forms -->
                        <form id="delete-form-{{ $class->id }}" action="{{ route('children.destroy', $class->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isMchungaji() || Auth::user()->isMhasibu() ? 8 : 7 }}">
                    <div class="rx-empty">
                        <div class="rx-empty-icon">
                            <i class="fas fa-chalkboard text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-900 mb-1">Hakuna madarasa yaliyopatikana</p>
                        <p class="text-xs text-gray-400 mb-4">Hakuna madarasa yanayolingana na vichujio vyako.</p>
                        @if(Auth::user()->isMchungaji() || Auth::user()->isMhasibu())
                        <a href="{{ route('children.create') }}" class="rx-btn rx-btn-primary">
                            <i class="fas fa-plus"></i> Ongeza Darasa Jipya
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($classes->hasPages())
<div class="px-6 py-4 border-t border-gray-100">
    {{ $classes->links() }}
</div>
@endif

<script>
if (typeof confirmAction === 'undefined') {
    console.log('Functions loaded from main page');
}
</script>
