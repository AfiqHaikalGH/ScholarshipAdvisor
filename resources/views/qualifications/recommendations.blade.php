<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('qualifications.index') }}"
                class="inline-flex items-center text-sm text-[#2C3BEB] hover:underline mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Qualifications
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Scholarship Recommendations</h1>
            <p class="text-sm text-gray-500 mt-1">Based on your academic profile, here are the top scholarships that
                match your qualifications.</p>
        </div>

        @if($recommendations === null)
            <div class="bg-white p-8 rounded-2xl border border-gray-200 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#2C3BEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Qualifications Not Filtered</h3>
                <p class="text-gray-500 mb-6">You have not filtered your qualifications yet. Please fill out the
                    qualifications form first to get your recommendations.</p>
                <a href="{{ route('qualifications.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-[#2C3BEB] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-[#2130d4] focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:ring-offset-2 transition ease-in-out duration-150">
                    Filter Qualifications
                </a>
            </div>
        @elseif(count($recommendations) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendations as $index => $scholarship)
                    <div
                        class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition duration-200 overflow-hidden flex flex-col">
                        <div class="h-2 bg-[#2C3BEB]"></div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Match Score: {{ number_format($scholarship['score'], 0) }}%
                                </span>
                                @if($index === 0)
                                    <span class="text-xs font-bold text-[#2C3BEB] bg-blue-50 px-2 py-1 rounded">Top Match</span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">
                                {{ $scholarship['name'] }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-4">
                                This scholarship aligns with your profile based on our weighted recommendation engine.
                            </p>

                            @if(isset($scholarship['matches']) && count($scholarship['matches']) > 0)
                                <div class="mb-4">
                                    <h4 class="text-[10px] font-bold uppercase text-gray-700 tracking-wider mb-2">Matched
                                        Eligibility</h4>
                                    <ul class="space-y-1.5">
                                        @foreach($scholarship['matches'] as $match)
                                            <li class="flex items-start text-xs text-gray-700">
                                                <svg class="w-3.5 h-3.5 text-green-500 mr-1.5 mt-0.5 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>{{ $match }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(isset($scholarship['missing']) && count($scholarship['missing']) > 0)
                                <div class="mb-6">
                                    <h4 class="text-[10px] font-bold uppercase text-gray-700 tracking-wider mb-2">Missing
                                        Eligibility</h4>
                                    <ul class="space-y-1.5">
                                        @foreach($scholarship['missing'] as $miss)
                                            <li class="flex items-start text-xs text-gray-700">
                                                <svg class="w-3.5 h-3.5 text-red-400 mr-1.5 mt-0.5 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span>{{ $miss }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <a href="#" target="_blank"
                                    class="block w-full text-center bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-medium py-2.5 px-4 rounded-lg transition duration-150">
                                    Apply Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-8 rounded-2xl border border-gray-200 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No perfect matches found</h3>
                <p class="text-gray-500 mb-6">We couldn't find any scholarships that strongly match your current profile.
                    Try updating your qualifications or checking back later as new scholarships are added.</p>
                <a href="{{ route('qualifications.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:ring-offset-2 transition ease-in-out duration-150">
                    Update Qualifications
                </a>
            </div>
        @endif
    </div>
</x-app-layout>