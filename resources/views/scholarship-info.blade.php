<x-app-layout headerTitle="Scholarship Information">
    <script>
        document.documentElement.classList.add('pending-unlock');
    </script>
    <style>
        .pending-unlock .anim-hero,
        .pending-unlock .anim-sidebar,
        .pending-unlock .anim-card {
            opacity: 0;
            pointer-events: none;
        }

        /* Animations */
        @keyframes flyInFromTop {
            0% { opacity: 0; transform: translateY(-80px) scale(0.95); }
            70% { transform: translateY(5px) scale(1.01); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes flyInFromBottom {
            0% { opacity: 0; transform: translateY(80px) scale(0.95); }
            70% { transform: translateY(-5px) scale(1.01); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes flyInFromLeft {
            0% { opacity: 0; transform: translateX(-80px) scale(0.95); }
            70% { transform: translateX(5px) scale(1.01); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes flyInFromRight {
            0% { opacity: 0; transform: translateX(80px) scale(0.95); }
            70% { transform: translateX(-5px) scale(1.01); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes flyInFromTopLeft {
            0% { opacity: 0; transform: translate(-80px, -80px) scale(0.95); }
            70% { transform: translate(5px, 5px) scale(1.01); }
            100% { opacity: 1; transform: translate(0, 0) scale(1); }
        }
        @keyframes flyInFromTopRight {
            0% { opacity: 0; transform: translate(80px, -80px) scale(0.95); }
            70% { transform: translate(-5px, 5px) scale(1.01); }
            100% { opacity: 1; transform: translate(0, 0) scale(1); }
        }
        @keyframes flyInScale {
            0% { opacity: 0; transform: scale(0.9); }
            70% { transform: scale(1.02); }
            100% { opacity: 1; transform: scale(1); }
        }

        .play-unlock .anim-hero { opacity: 0; animation: flyInFromTop 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; animation-delay: 50ms; }
        .play-unlock .anim-sidebar { opacity: 0; animation: flyInFromLeft 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; animation-delay: 100ms; }
        .play-unlock .anim-card { opacity: 0; animation-duration: 0.6s; animation-timing-function: cubic-bezier(0.2, 0.8, 0.2, 1); animation-fill-mode: forwards; }
    </style>

    <!-- Hero Section -->
    <div class="relative w-full rounded-3xl overflow-hidden flex items-center mb-6 shadow-md h-[140px] md:h-[180px] anim-hero"
         style="background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat, linear-gradient(to right, #C8D5F8, #BDD0FF);">

        <!-- Left overlay gradient so text is readable -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#C8D5F8]/95 via-[#C8D5F8]/60 to-transparent pointer-events-none"></div>

        <!-- Text Content -->
        <div class="relative z-10 px-6 md:px-10 max-w-xs md:max-w-md">
            <h1 class="text-lg md:text-2xl font-extrabold text-[#0B1221] tracking-tight leading-tight mb-1">
                Find the right scholarship <br />
                <span class="text-[#1E2DB8]">for your future</span>
            </h1>
            <p class="text-[10px] md:text-xs text-gray-700 leading-snug font-medium mt-1">
                Discover opportunities that match your profile<br class="hidden md:block"> and support your academic journey.
            </p>
        </div>
    </div>

    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'representative']))
    <div class="flex justify-end mb-6 md:-mt-4">
        <a href="{{ route('scholarships.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#2C3BEB] text-white font-bold text-sm rounded-lg hover:bg-[#2130d4] transition shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Create Scholarship
        </a>
    </div>
    @endif

    <!-- Dashboard Layout: 2 Columns -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        @if(!auth()->check() || auth()->user()->role !== 'representative')
        <!-- Left Column: Filters Sidebar -->
        <div class="w-full lg:w-72 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-6 anim-sidebar">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filters
                    </h2>
                    @if(request()->anyFilled(['search', 'provider', 'level']))
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



                    <button type="submit" class="w-full py-2.5 bg-[#2C3BEB] text-white font-bold text-sm rounded-lg hover:bg-[#2130d4] transition-colors shadow-sm">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Right Column: Results Grid -->
        <div class="flex-grow">
            <!-- Active Filters Badge Area -->
            @if(request()->anyFilled(['search', 'provider', 'level']))
                <div class="mb-4 text-sm text-gray-600 flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Showing results for:</span>
                    @if(request('search')) <span class="bg-blue-50 text-[#2C3BEB] px-2 py-1 rounded border border-blue-100 text-xs font-medium">"{{ request('search') }}"</span> @endif
                    @if(request('provider') && request('provider') !== 'All') <span class="bg-blue-50 text-[#2C3BEB] px-2 py-1 rounded border border-blue-100 text-xs font-medium">Provider: {{ request('provider') }}</span> @endif

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
                    @if(request()->anyFilled(['search', 'provider', 'level']))
                        <a href="{{ route('scholarship.info') }}" class="mt-6 px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 text-sm transition-colors">Clear All Filters</a>
                    @endif
                </div>
            @else
                <!-- Scholarship Grid — 3 cols desktop, 2 tablet, 1 mobile -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($scholarships as $scholarship)
                        <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col transition-all duration-200 hover:-translate-y-1 hover:shadow-lg hover:border-blue-200 relative overflow-hidden group anim-card">

                            <!-- Status & Type Badges -->
                            <div class="flex flex-wrap gap-1.5 mb-2.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $scholarship->application_status === 'Open' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                                    @if($scholarship->application_status === 'Open')
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    @endif
                                    {{ $scholarship->application_status ?? 'Unknown' }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ !empty($scholarship->apply_url) ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-indigo-50 text-indigo-600 border border-indigo-200' }}">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if(!empty($scholarship->apply_url))
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        @endif
                                    </svg>
                                    {{ !empty($scholarship->apply_url) ? 'Online' : 'Offline' }}
                                </span>
                            </div>

                            <!-- Scholarship Name -->
                            <h3 class="text-sm font-bold text-gray-900 leading-snug mb-1.5 uppercase tracking-wide group-hover:text-[#2C3BEB] transition-colors line-clamp-2 flex-grow">
                                {{ $scholarship->name }}
                            </h3>

                            <!-- Provider -->
                            <div class="flex items-center gap-1.5 text-gray-500 mb-3">
                                <svg class="shrink-0 text-gray-400" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                                <span class="text-[11px] font-semibold uppercase tracking-wider truncate">{{ $scholarship->provider ?? 'Unknown Provider' }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="border-t border-gray-100 pt-3 flex flex-col gap-1.5">
                                <a href="{{ route('scholarships.show', $scholarship->id) }}" class="block w-full py-1.5 bg-[#2C3BEB] hover:bg-[#2130d4] text-white text-center font-semibold text-xs rounded-lg transition-all">
                                    View Detailed Requirements
                                </a>

                                @if(auth()->user() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'representative' && auth()->user()->provider_name === $scholarship->provider)))
                                <div class="grid grid-cols-2 gap-1.5">
                                    <a href="{{ route('scholarships.edit', $scholarship->id) }}" class="block py-1.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-center font-semibold text-[11px] rounded-lg transition-colors border border-yellow-200">
                                        Update
                                    </a>
                                    <button type="button" onclick="openDeleteModal('{{ route('scholarships.destroy', $scholarship->id) }}', 'Delete Scholarship?', 'Are you sure you want to delete this scholarship?<br>This action is permanent and cannot be undone.')" class="w-full py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-center font-semibold text-[11px] rounded-lg transition-colors border border-red-200">
                                        Delete
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $scholarships->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <script>
        if (document.documentElement.classList.contains('pending-unlock')) {
            // Wait for next paint
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    document.documentElement.classList.remove('pending-unlock');
                    document.documentElement.classList.add('play-unlock');
                    
                    // Assign specific animations and delays to cards
                    const cards = document.querySelectorAll('.anim-card');
                    cards.forEach((card, index) => {
                        // Calculate delay: stagger by 50ms, starting after sidebar (100ms)
                        const delay = 150 + (index * 50);
                        card.style.animationDelay = `${delay}ms`;
                        
                        // Determine direction based on index (assuming 3 columns max)
                        const col = index % 3;
                        const row = Math.floor(index / 3);
                        
                        if (row === 0) {
                            if (col === 0) card.style.animationName = 'flyInFromTopLeft';
                            else if (col === 1) card.style.animationName = 'flyInFromTop';
                            else card.style.animationName = 'flyInFromTopRight';
                        } else if (row === 1) {
                            if (col === 0) card.style.animationName = 'flyInFromLeft';
                            else if (col === 1) card.style.animationName = 'flyInScale';
                            else card.style.animationName = 'flyInFromRight';
                        } else {
                            card.style.animationName = 'flyInFromBottom';
                        }
                    });
                });
            });
        }
    </script>
    <script>
        // Smooth scroll for category links (if needed)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    
    @include('profile.partials.delete-account-modal')
</x-app-layout>
