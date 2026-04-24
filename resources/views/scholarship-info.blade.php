<x-app-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Scholarship Information</h1>
            <p class="text-sm text-gray-500 mt-1">Browse and filter available scholarship opportunities.</p>
        </div>
    </div>

    <!-- Dashboard Layout: 2 Columns -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Column: Filters Sidebar -->
        <div class="w-full lg:w-72 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filters
                    </h2>
                    @if(request()->anyFilled(['search', 'provider', 'level', 'location']))
                        <a href="{{ route('scholarship.info') }}" class="text-xs text-red-500 hover:text-red-700 font-semibold transition-colors">Clear All</a>
                    @endif
                </div>

                <form action="{{ route('scholarship.info') }}" method="GET" class="space-y-6">
                    
                    <!-- Search Keyword -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Search Keyword</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="e.g. Engineering" class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Provider Selection -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Provider</label>
                        <select name="provider" class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent bg-white">
                            <option value="All">All Providers</option>
                            @foreach($providers as $prov)
                                <option value="{{ $prov }}" {{ request('provider') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Education Level -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">Education Level</label>
                        <div class="space-y-2">
                            @php $selectedLevels = request('level', []); !is_array($selectedLevels) ? $selectedLevels = [$selectedLevels] : null; @endphp
                            
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="level[]" value="Diploma" {{ in_array('Diploma', $selectedLevels) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB]">
                                <span class="text-sm text-gray-700">Diploma</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="level[]" value="Bachelor" {{ in_array('Bachelor', $selectedLevels) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB]">
                                <span class="text-sm text-gray-700">Bachelor's Degree</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="level[]" value="Master" {{ in_array('Master', $selectedLevels) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB]">
                                <span class="text-sm text-gray-700">Master's Degree</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="level[]" value="PhD" {{ in_array('PhD', $selectedLevels) ? 'checked' : '' }} class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB]">
                                <span class="text-sm text-gray-700">PhD</span>
                            </label>
                        </div>
                    </div>

                    <!-- Place of Study -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Study Location</label>
                        <select name="location" class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent bg-white">
                            <option value="All">Anywhere</option>
                            <option value="Local" {{ request('location') == 'Local' ? 'selected' : '' }}>Local (Malaysia)</option>
                            <option value="Overseas" {{ request('location') == 'Overseas' ? 'selected' : '' }}>Overseas</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#2C3BEB] text-white font-bold text-sm rounded-lg hover:bg-[#2130d4] transition-colors shadow-sm">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Results Grid -->
        <div class="flex-grow">
            <!-- Active Filters Badge Area -->
            @if(request()->anyFilled(['search', 'provider', 'level', 'location']))
                <div class="mb-4 text-sm text-gray-600 flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Showing results for:</span>
                    @if(request('search')) <span class="bg-blue-50 text-[#2C3BEB] px-2 py-1 rounded border border-blue-100 text-xs font-medium">"{{ request('search') }}"</span> @endif
                    @if(request('provider') && request('provider') !== 'All') <span class="bg-blue-50 text-[#2C3BEB] px-2 py-1 rounded border border-blue-100 text-xs font-medium">Provider: {{ request('provider') }}</span> @endif
                    @if(request('location') && request('location') !== 'All') <span class="bg-blue-50 text-[#2C3BEB] px-2 py-1 rounded border border-blue-100 text-xs font-medium">Location: {{ request('location') }}</span> @endif
                </div>
            @endif

            @if($scholarships->isEmpty())
                <!-- Empty content placeholder -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 flex flex-col items-center justify-center text-center mt-2">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2C3BEB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-2">No Match Found</h2>
                    <p class="text-sm text-gray-500 max-w-sm">We couldn't find any scholarships matching your current filters. Try adjusting your search criteria or clearing filters.</p>
                    @if(request()->anyFilled(['search', 'provider', 'level', 'location']))
                        <a href="{{ route('scholarship.info') }}" class="mt-6 px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 text-sm transition-colors">Clear All Filters</a>
                    @endif
                </div>
            @else
                <!-- Scholarship Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($scholarships as $scholarship)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col transition-all hover:shadow-lg hover:border-blue-200 h-full relative overflow-hidden group">
                            
                            <div class="flex-grow z-10">
                                <!-- Status Badge -->
                                <div class="mb-3 inline-flex">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $scholarship->application_status === 'Open' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                        @if($scholarship->application_status === 'Open')
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        @endif
                                        {{ $scholarship->application_status ?? 'Status Unknown' }}
                                    </span>
                                </div>

                                <!-- Name -->
                                <h3 class="text-lg font-bold text-gray-900 leading-tight mb-3 uppercase tracking-wide group-hover:text-[#2C3BEB] transition-colors">
                                    {{ $scholarship->name }}
                                </h3>
                                
                                <!-- Provider -->
                                <div class="flex items-start gap-2 text-gray-600 mb-4">
                                    <svg class="mt-0.5 shrink-0 text-gray-400" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M9 8h1"/><path d="M9 12h1"/><path d="M9 16h1"/><path d="M14 8h1"/><path d="M14 12h1"/><path d="M14 16h1"/><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">{{ $scholarship->provider ?? 'Unknown Provider' }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-6 z-10 flex flex-col gap-2 border-t border-gray-100 pt-5">
                                <a href="{{ route('scholarships.show', $scholarship->id) }}" class="block w-full py-2.5 bg-gray-50 border border-gray-200 hover:bg-[#2C3BEB] hover:text-white hover:border-[#2C3BEB] text-gray-800 text-center font-bold text-sm rounded-lg transition-all">
                                    View Detailed Requirements
                                </a>
                                
                                @if(auth()->user() && auth()->user()->role === 'admin')
                                <div class="grid grid-cols-2 gap-2 mt-1">
                                    <a href="{{ route('scholarships.edit', $scholarship->id) }}" class="block py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-center font-bold text-[13px] rounded-lg transition-colors border border-yellow-200">
                                        Update
                                    </a>

                                    <form action="{{ route('scholarships.destroy', $scholarship->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this scholarship? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full py-2 bg-red-50 hover:bg-red-100 text-red-700 text-center font-bold text-[13px] rounded-lg transition-colors border border-red-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $scholarships->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
