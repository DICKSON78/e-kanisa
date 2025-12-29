@extends('layouts.app')

@section('title', 'Huduma za Kichungaji - Mfumo wa Kanisa')
@section('page-title', 'Huduma za Kichungaji')
@section('page-subtitle', 'Usimamizi wa maombi ya huduma za kichungaji')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Huduma za Kichungaji</h1>
            <p class="text-gray-600 mt-2">Usimamizi kamili wa maombi ya huduma za kichungaji</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('pastoral-services.create') }}" class="text-white px-5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800">
                <i class="fas fa-plus"></i>
                <span class="font-medium">Omba Huduma</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Jumla ya Maombi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Zinasubiri</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Zimeidhinishwa</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Zimekamilika</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['completed'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-double text-xl text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Zimekataliwa</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
                </div>
                <div class="h-12 w-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-xl text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter text-primary-500 mr-2"></i> Chuja Maombi
            </h3>
        </div>
        <form method="GET" action="{{ route('pastoral-services.index') }}" data-auto-filter="true" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hali</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Zote</option>
                        <option value="Inasubiri" {{ request('status') == 'Inasubiri' ? 'selected' : '' }}>Zinasubiri</option>
                        <option value="Imeidhinishwa" {{ request('status') == 'Imeidhinishwa' ? 'selected' : '' }}>Zimeidhinishwa</option>
                        <option value="Imekamilika" {{ request('status') == 'Imekamilika' ? 'selected' : '' }}>Zimekamilika</option>
                        <option value="Imekataliwa" {{ request('status') == 'Imekataliwa' ? 'selected' : '' }}>Zimekataliwa</option>
                    </select>
                </div>

                <!-- Service Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aina ya Huduma</label>
                    <select name="service_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Zote</option>
                        @foreach($serviceTypes as $type)
                            <option value="{{ $type }}" {{ request('service_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe Kuanzia</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarehe Mwisho</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('pastoral-services.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    <span>Futa Chujio</span>
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Tumia Chujio</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Services Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list text-primary-500 mr-2"></i> Orodha ya Maombi ya Huduma
                    <span class="ml-3 text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $services->total() }} maombi
                    </span>
                </h3>
            </div>
            <div class="mt-3 sm:mt-0">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary-500"></i>
                    <span>Angalia au hariri ombi kwa kubofya vitendo</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-primary-600 text-white text-sm">
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-hashtag mr-2"></i>
                                Namba ya Huduma
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Muumini
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-hands-helping mr-2"></i>
                                Aina ya Huduma
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-day mr-2"></i>
                                Tarehe Inayopendelewa
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-circle mr-2"></i>
                                Hali
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Tarehe ya Kuomba
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left font-semibold uppercase tracking-wider sticky right-0 bg-primary-600">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2"></i>
                                Vitendo
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($services as $service)
                    <tr class="bg-white hover:bg-gray-50 transition-all duration-200">
                        <!-- Service Number -->
                        <td class="py-4 px-6">
                            <div class="font-mono text-sm font-medium text-gray-900 bg-gray-100 px-2 py-1 rounded inline-block">
                                {{ $service->service_number }}
                            </div>
                        </td>

                        <!-- Member Name -->
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">
                                {{ $service->member->first_name }} {{ $service->member->last_name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $service->member->member_number }}
                            </div>
                        </td>

                        <!-- Service Type -->
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-hands-helping mr-1"></i>
                                {{ $service->service_type }}
                            </span>
                        </td>

                        <!-- Preferred Date -->
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-600">
                                @if($service->preferred_date)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-day text-gray-400"></i>
                                    {{ \Carbon\Carbon::parse($service->preferred_date)->format('d/m/Y') }}
                                </div>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-6">
                            @if($service->status == 'Inasubiri')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Inasubiri
                                </span>
                            @elseif($service->status == 'Imeidhinishwa')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Imeidhinishwa
                                </span>
                            @elseif($service->status == 'Imekamilika')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-check-double mr-1"></i>
                                    Imekamilika
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Imekataliwa
                                </span>
                            @endif
                        </td>

                        <!-- Application Date -->
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                    {{ \Carbon\Carbon::parse($service->created_at)->format('d/m/Y') }}
                                </div>
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-6 text-sm sticky right-0 bg-white">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('pastoral-services.show', $service->id) }}"
                                   class="h-8 w-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-all duration-200"
                                   title="Angalia Maelezo">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>

                                @if($service->status == 'Inasubiri')
                                <a href="{{ route('pastoral-services.edit', $service->id) }}"
                                   class="h-8 w-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-all duration-200"
                                   title="Hariri">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <form action="{{ route('pastoral-services.destroy', $service->id) }}" method="POST" class="inline" onsubmit="return confirm('Je, una uhakika unataka kufuta ombi hili?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="h-8 w-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-all duration-200"
                                            title="Futa">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-6 text-center">
                            <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-hands-helping text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hakuna Maombi Yaliyopatikana</h3>
                            <p class="text-gray-500 mb-6">Hakuna maombi ya huduma yanayolingana na vichujio vyako.</p>
                            <a href="{{ route('pastoral-services.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i> Omba Huduma Mpya
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
