<x-app-layout headerTitle="Recommendations">
    <script>
        document.documentElement.classList.add('pending-unlock');
    </script>
    <style>
        .pending-unlock .anim-hero,
        .pending-unlock .anim-card {
            opacity: 0;
            pointer-events: none;
        }
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
        .play-unlock .anim-card { opacity: 0; animation-duration: 0.6s; animation-timing-function: cubic-bezier(0.2, 0.8, 0.2, 1); animation-fill-mode: forwards; }
    </style>

    <div class="max-w-7xl mx-auto pb-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Banner -->
        <div class="relative w-full rounded-3xl overflow-hidden flex items-center mb-6 shadow-md h-[140px] md:h-[180px] mt-2 anim-hero"
             style="background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat, linear-gradient(to right, #C8D5F8, #BDD0FF);">
            <div class="absolute inset-0 bg-gradient-to-r from-[#C8D5F8]/95 via-[#C8D5F8]/60 to-transparent pointer-events-none"></div>
            <div class="relative z-10 px-8 md:px-12 max-w-2xl">
                <div class="flex items-center gap-4 mb-3">
                    <div class="p-2.5 bg-white rounded-xl shadow-sm text-[#2C3BEB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#0B1221] tracking-tight leading-tight">Scholarship Recommendations</h1>
                </div>
                <p class="text-sm text-gray-800 leading-relaxed font-semibold">Based on your academic profile, here are the top scholarships that match your qualifications.</p>
            </div>
        </div>

        @if($recommendations === null)
            <div class="bg-white p-12 rounded-2xl border border-gray-100 shadow-sm text-center max-w-2xl mx-auto mt-12">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#2C3BEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Qualifications Not Filtered</h3>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">You have not filtered your qualifications yet. Please fill out the qualifications form first to generate your personalized recommendations.</p>
                <a href="{{ route('qualifications.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-[#2C3BEB] rounded-xl font-bold text-white hover:bg-[#2130d4] hover:-translate-y-0.5 transition-all shadow-md hover:shadow-lg">
                    Filter Qualifications <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @elseif(count($recommendations) > 0)
            
        
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($recommendations as $index => $scholarship)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-blue-200 transition-all duration-300 overflow-hidden flex flex-col p-4 relative group anim-card">
                        
                        <!-- Header / Badges -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#2C3BEB] border border-blue-100 uppercase tracking-wide">
                                Match Score: {{ number_format($scholarship['score'], 0) }}%
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold {{ $scholarship['score'] == 100 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }} uppercase tracking-wide">
                                {{ $scholarship['score'] == 100 ? 'Eligible' : 'Not Eligible' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug group-hover:text-[#2C3BEB] transition-colors line-clamp-2 min-h-[44px]">
                            {{ $scholarship['name'] }}
                        </h3>

                        <!-- Criteria Section -->
                        <div class="mb-3 flex-grow">
                            
                            @if(isset($scholarship['matches']) && count($scholarship['matches']) > 0)
                                <h4 class="text-[11px] font-bold text-gray-900 mb-1.5 tracking-wide">Matched Criteria</h4>
                                <ul class="space-y-1">
                                    @foreach(array_slice($scholarship['matches'], 0, 4) as $match)
                                    <li class="flex items-start text-[11px] text-gray-700 font-semibold">
                                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="leading-relaxed">{{ $match }}</span>
                                    </li>
                                    @endforeach
                                    
                                    @if(count($scholarship['matches']) > 4)
                                    <li class="mt-1">
                                        <div id="more-matches-{{ $index }}" class="hidden space-y-1 mb-1">
                                            @foreach(array_slice($scholarship['matches'], 4) as $match)
                                            <div class="flex items-start text-[11px] text-gray-700 font-semibold">
                                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="leading-relaxed">{{ $match }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" onclick="let list = document.getElementById('more-matches-{{ $index }}'); list.classList.toggle('hidden'); this.innerText = list.classList.contains('hidden') ? '+ {{ count($scholarship['matches']) - 4 }} more matches' : '- See less';" class="pl-6 text-[10px] text-[#2C3BEB] font-bold hover:underline focus:outline-none cursor-pointer">
                                            + {{ count($scholarship['matches']) - 4 }} more matches
                                        </button>
                                    </li>
                                    @endif
                                </ul>
                            @endif

                            @if(isset($scholarship['missing']) && count($scholarship['missing']) > 0)
                                <h4 class="text-[11px] font-bold text-gray-900 mb-1.5 mt-3 tracking-wide">Missing Criteria</h4>
                                <ul class="space-y-1">
                                    @foreach(array_slice($scholarship['missing'], 0, 3) as $miss)
                                    <li class="flex items-start text-[11px] text-gray-500 font-medium opacity-80">
                                        <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        <span class="leading-relaxed">{{ $miss }}</span>
                                    </li>
                                    @endforeach
                                    
                                    @if(count($scholarship['missing']) > 3)
                                    <li class="mt-1">
                                        <div id="more-missing-{{ $index }}" class="hidden space-y-1 mb-1">
                                            @foreach(array_slice($scholarship['missing'], 3) as $miss)
                                            <div class="flex items-start text-[11px] text-gray-500 font-medium opacity-80">
                                                <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span class="leading-relaxed">{{ $miss }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" onclick="let list = document.getElementById('more-missing-{{ $index }}'); list.classList.toggle('hidden'); this.innerText = list.classList.contains('hidden') ? '+ {{ count($scholarship['missing']) - 3 }} more missing criteria' : '- See less';" class="pl-6 text-[10px] text-gray-500 font-bold hover:underline focus:outline-none cursor-pointer">
                                            + {{ count($scholarship['missing']) - 3 }} more missing criteria
                                        </button>
                                    </li>
                                    @endif
                                </ul>
                            @endif
                        </div>

                        <!-- Action Area -->
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            @if($scholarship['score'] == 100)
                                <form method="POST" action="{{ route('applications.apply') }}" class="apply-form flex gap-3">
                                    @csrf
                                    <input type="hidden" name="scholarship_name" value="{{ $scholarship['name'] }}">
                                    <input type="hidden" name="apply_url" value="{{ $scholarship['apply_url'] }}">

                                    @if($scholarship['applied'])
                                        <button type="button" class="w-full inline-flex items-center justify-center gap-1.5 bg-green-600 text-white font-bold py-1.5 px-3 rounded-lg cursor-default text-[11px] shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Applied
                                        </button>
                                    @elseif(empty($scholarship['apply_url']))
                                        <a href="{{ route('applications.offline-form', ['scholarship' => $scholarship['name']]) }}" class="w-full inline-flex items-center justify-center gap-1.5 bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-bold py-1.5 px-3 rounded-lg transition-all shadow-sm hover:shadow-md text-[11px]">
                                            Apply Now <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    @else
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-bold py-1.5 px-3 rounded-lg transition-all shadow-sm hover:shadow-md text-[11px]">
                                            Apply Now <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    @endif
                                </form>
                            @else
                                <div class="w-full text-center py-1.5 px-3 rounded-lg bg-gray-50 text-gray-500 font-semibold text-[11px] border border-gray-100">
                                    Does Not Meet Requirements
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-12 rounded-2xl border border-gray-100 shadow-sm text-center max-w-2xl mx-auto mt-12">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">No perfect matches found</h3>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">We couldn't find any scholarships that strongly match your current profile. Try updating your qualifications or checking back later as new scholarships are added.</p>
                <a href="{{ route('qualifications.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition-all shadow-sm hover:shadow-md">
                    Update Qualifications
                </a>
            </div>
        @endif
    </div>

    <script>
        if (document.documentElement.classList.contains('pending-unlock')) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    document.documentElement.classList.remove('pending-unlock');
                    document.documentElement.classList.add('play-unlock');

                    const cards = document.querySelectorAll('.anim-card');
                    cards.forEach((card, index) => {
                        const delay = 150 + (index * 50);
                        card.style.animationDelay = `${delay}ms`;

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
        document.querySelectorAll('.apply-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalContent = submitBtn.innerHTML;
                const applyUrl  = form.querySelector('[name="apply_url"]').value;
                const csrfToken = form.querySelector('[name="_token"]').value;
                const formData  = new FormData(form);

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Processing...';

                // Record the application via AJAX
                fetch('/applications/apply', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalContent;
                        window.open(applyUrl, '_blank');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                    alert('Something went wrong while recording your application. Please try again.');
                });
            });
        });
    </script>
</x-app-layout>