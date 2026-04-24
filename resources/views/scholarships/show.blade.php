<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <!-- Header Section -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8 p-8 relative">
            <!-- Decorative accent -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-[#2C3BEB]"></div>
            
            <div class="flex justify-between items-start gap-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-[#2C3BEB] text-xs font-semibold uppercase tracking-wider mb-4 border border-blue-100">
                        Scholarship
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900 leading-tight mb-2 uppercase">{{ $scholarship->name }}</h1>
                    
                    <div class="flex items-center gap-2 text-gray-600 mt-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M9 8h1"/><path d="M9 12h1"/><path d="M9 16h1"/><path d="M14 8h1"/><path d="M14 12h1"/><path d="M14 16h1"/><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                        <span class="font-medium text-[15px]">{{ $scholarship->provider ?? 'Unknown Provider' }}</span>
                    </div>
                </div>
                
                <div class="text-right shrink-0">
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1">Status</p>
                    <div class="inline-flex items-center gap-1.5 {{ $scholarship->application_status === 'Open' ? 'text-green-600' : 'text-gray-500' }}">
                        <div class="w-2 h-2 rounded-full {{ $scholarship->application_status === 'Open' ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></div>
                        <span class="font-bold text-lg">{{ $scholarship->application_status ?? 'Unknown' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Description -->
                @if($scholarship->description)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                    <h2 class="text-[19px] font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="text-[#2C3BEB]" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Description
                    </h2>
                    <div class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $scholarship->description }}</div>
                </div>
                @endif
                
                <!-- General Requirements -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                    <h2 class="text-[19px] font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="text-[#2C3BEB]" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        General Requirements
                    </h2>

                <ul class="space-y-5">
                        <li class="flex items-start gap-4">
                            <span class="bg-gray-100 text-gray-500 w-6 h-6 rounded-md flex items-center justify-center shrink-0 mt-0.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Citizenship</p>
                                <p class="text-sm text-gray-600">{{ $scholarship->citizenship ?? 'Any' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-gray-100 text-gray-500 w-6 h-6 rounded-md flex items-center justify-center shrink-0 mt-0.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Income Category</p>
                                <p class="text-sm text-gray-600">{{ $scholarship->income_category ?? 'Any' }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="bg-gray-100 text-gray-500 w-6 h-6 rounded-md flex items-center justify-center shrink-0 mt-0.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Health Requirement</p>
                                <p class="text-sm text-gray-600">{{ $scholarship->health_requirement ?? 'Not specified' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>


                <!-- Entry Qualification Requirements -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                    <h2 class="text-[19px] font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="text-[#2C3BEB]" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        Entry Qualification Requirements
                    </h2>

                    @php
                        $levelConfig = [
                            0 => ['label' => 'Diploma',  'badge_bg' => '#0891b2', 'border' => 'border-cyan-200',   'header_bg' => 'bg-cyan-50',   'header_border' => 'border-b border-cyan-200'],
                            1 => ['label' => 'Bachelor', 'badge_bg' => '#2C3BEB', 'border' => 'border-indigo-200', 'header_bg' => 'bg-indigo-50', 'header_border' => 'border-b border-indigo-200'],
                            2 => ['label' => 'Master',   'badge_bg' => '#7e22ce', 'border' => 'border-purple-200', 'header_bg' => 'bg-purple-50', 'header_border' => 'border-b border-purple-200'],
                            3 => ['label' => 'PhD',      'badge_bg' => '#be123c', 'border' => 'border-rose-200',   'header_bg' => 'bg-rose-50',   'header_border' => 'border-b border-rose-200'],
                        ];
                    @endphp

                    @if($scholarship->scholarshipLevels->count() > 0)
                        <div class="space-y-5">
                        @foreach($scholarship->scholarshipLevels as $idx => $level)
                            @php
                                $reqs    = $level->additional_requirements ? json_decode($level->additional_requirements, true) : [];
                                $reqs    = is_array($reqs) ? $reqs : [];
                                
                                $levelName = is_array($level->education_levels) ? ($level->education_levels[0] ?? 'Bachelor') : 'Bachelor';
                                $cfgIdx = match($levelName) {
                                    'Diploma' => 0,
                                    'Bachelor' => 1,
                                    'Master' => 2,
                                    'PhD' => 3,
                                    default => 1
                                };
                                $cfg = $levelConfig[$cfgIdx];

                                $cgpaRows = array_filter([
                                    'Diploma'                    => $level->min_diploma_cgpa,
                                    'Foundation / Matriculation' => $level->min_foundation_cgpa,
                                    'STPM'                       => $level->min_stpm_cgpa,
                                    'Bachelor'                   => $level->min_bachelor_cgpa,
                                    'Master'                     => $level->min_master_cgpa,
                                ], fn($v) => !is_null($v) && $v !== '');

                                $hasSpm = !empty($reqs['min_spm_result']) || (!empty($reqs['spm_subjects']) && count($reqs['spm_subjects']) > 0);
                                $hasAny = count($cgpaRows) || $hasSpm || $level->age_limit || !empty($reqs['place_of_study']) || !empty($reqs['field_of_study']) || !empty($level->muet_band) || !empty($reqs['cefr']) || !empty($reqs['additional_requirements']);
                            @endphp

                            <div class="rounded-xl border {{ $cfg['border'] }} overflow-hidden">
                                {{-- Level header --}}
                                <div class="{{ $cfg['header_bg'] }} {{ $cfg['header_border'] }} flex items-center gap-3 px-5 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white tracking-wider uppercase"
                                          style="background-color: {{ $cfg['badge_bg'] }}">{{ $cfg['label'] }}</span>
                                    <span class="text-xs text-gray-500">Minimum qualifications for a {{ $cfg['label'] }}'s degree scholarship</span>
                                </div>

                                @if($hasAny)
                                <div class="p-5 space-y-5 bg-white">

                                    {{-- CGPA Grid --}}
                                    @if(count($cgpaRows))
                                    <div>
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Minimum CGPA</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-{{ min(count($cgpaRows), 4) }} gap-3">
                                            @foreach($cgpaRows as $cgpaLabel => $cgpa)
                                            <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center">
                                                <p class="text-[11px] text-gray-500 font-medium mb-1">{{ $cgpaLabel }}</p>
                                                <p class="text-xl font-extrabold text-gray-900">{{ number_format($cgpa, 2) }}</p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    {{-- SPM Requirements --}}
                                    @if($hasSpm)
                                    <div class="border-t border-gray-100 pt-4">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">SPM Requirements</p>
                                        @if(!empty($reqs['min_spm_result']))
                                            <p class="text-sm text-gray-700 font-medium mb-2">
                                                Minimum overall result: <span class="font-bold text-gray-900">{{ $reqs['min_spm_result'] }}</span>
                                            </p>
                                        @endif
                                        @if(!empty($reqs['spm_subjects']) && count($reqs['spm_subjects']) > 0)
                                            <div class="overflow-hidden rounded-lg border border-gray-100">
                                                <table class="w-full text-sm">
                                                    <thead>
                                                        <tr class="bg-gray-50 border-b border-gray-100">
                                                            <th class="text-left px-4 py-2 text-[11px] font-bold text-gray-500 uppercase tracking-wide">Subject</th>
                                                            <th class="text-center px-4 py-2 text-[11px] font-bold text-gray-500 uppercase tracking-wide w-20">Min Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-50">
                                                        @foreach($reqs['spm_subjects'] as $subject => $grade)
                                                        <tr class="hover:bg-gray-50/50">
                                                            <td class="px-4 py-2.5 text-gray-700">{{ $subject }}</td>
                                                            <td class="px-4 py-2.5 text-center font-bold text-gray-900">{{ $grade }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                    @endif

                                    {{-- Info Row: Age / Place / Field / MUET / CEFR --}}
                                    @php
                                        $infoItems = array_filter([
                                            'Age Limit'      => $level->age_limit ? 'Max ' . $level->age_limit . ' years old' : null,
                                            'Place of Study' => $reqs['place_of_study'] ?? null,
                                            'Field of Study' => isset($reqs['field_of_study']) ? (is_array($reqs['field_of_study']) ? implode(', ', $reqs['field_of_study']) : $reqs['field_of_study']) : null,
                                            'MUET Band'      => $level->muet_band ? 'Minimum ' . $level->muet_band : null,
                                            'CEFR English'   => !empty($reqs['cefr']) ? 'Minimum ' . $reqs['cefr'] : null,
                                        ]);
                                    @endphp
                                    @if(count($infoItems))
                                    <div class="border-t border-gray-100 pt-4">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Other Requirements</p>
                                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                                            @foreach($infoItems as $iLabel => $iVal)
                                            <div>
                                                <dt class="text-xs font-semibold text-gray-500">{{ $iLabel }}</dt>
                                                <dd class="text-sm font-medium text-gray-900 mt-0.5">{{ $iVal }}</dd>
                                            </div>
                                            @endforeach
                                        </dl>
                                    </div>
                                    @endif

                                    {{-- Additional Remarks --}}
                                    @if(!empty($reqs['additional_requirements']))
                                    <div class="border-t border-gray-100 pt-4">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Additional Remarks</p>
                                        <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $reqs['additional_requirements'] }}</p>
                                    </div>
                                    @endif

                                </div>
                                @else
                                <div class="px-5 py-4 bg-white">
                                    <p class="text-sm text-gray-400 italic">Not offered for this level.</p>
                                </div>
                                @endif
                            </div>
                        @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic bg-gray-50 p-4 rounded-lg border border-gray-100">No specific education level criteria provided.</p>
                    @endif
                </div>


                <!-- Program Details -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                    <h2 class="text-[19px] font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="text-[#2C3BEB]" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6"/><path d="M2 10h20"/><path d="m14 18 2 2 4-4"/></svg>
                        Additional Information
                    </h2>
                    
                    <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Bond Requirement</p>
                            <p class="text-[14px] font-medium text-gray-900">
                                @if($scholarship->bond_required)
                                    Yes <span class="text-gray-500 font-normal">({{ $scholarship->bond_duration }} years with {{ $scholarship->bond_organization }})</span>
                                @else
                                    No Bond Required
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Other Restrictions</p>
                            <p class="text-[14px] font-medium text-gray-900 text-gray-600">
                                @if($scholarship->has_other_scholarship_restriction) No other scholarships allowed. @endif
                                @if($scholarship->blacklist_status) No blacklisted status. @endif
                                @if(!$scholarship->has_other_scholarship_restriction && !$scholarship->blacklist_status) - @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-6">
                <!-- Dates Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-3">Important Dates</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Opening Date</p>
                            <p class="text-[14px] font-medium text-gray-900 flex items-center gap-2">
                                <svg class="text-gray-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $scholarship->application_start_date ? \Carbon\Carbon::parse($scholarship->application_start_date)->format('d M Y') : 'TBA' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Closing Date</p>
                            <p class="text-[14px] font-medium text-gray-900 flex items-center gap-2">
                                <svg class="text-red-400" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $scholarship->application_end_date ? \Carbon\Carbon::parse($scholarship->application_end_date)->format('d M Y') : 'TBA' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('scholarship.info') }}" class="text-sm text-[#2C3BEB] font-semibold hover:underline bg-white px-4 py-2 rounded-lg border border-gray-200">
                &larr; Back to all scholarships
            </a>
        </div>
    </div>
</x-app-layout>
