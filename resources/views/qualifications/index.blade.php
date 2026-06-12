<x-app-layout headerTitle="Qualifications">
    @php
        $malaysianStates = [
            'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 
            'Pulau Pinang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 
            'Wilayah Persekutuan Kuala Lumpur', 'Wilayah Persekutuan Putrajaya', 'Wilayah Persekutuan Labuan', 
            'Outside Malaysia'
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        
        <!-- Hero Banner -->
        <div class="relative w-full rounded-3xl overflow-hidden flex items-center mb-8 shadow-md h-[140px] md:h-[180px] mt-2"
             style="background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat, linear-gradient(to right, #C8D5F8, #BDD0FF);">
            <div class="absolute inset-0 bg-gradient-to-r from-[#C8D5F8]/95 via-[#C8D5F8]/60 to-transparent pointer-events-none"></div>
            <div class="relative z-10 px-8 md:px-12 max-w-xl">
                <div class="flex items-center gap-4 mb-3">
                    <div class="p-2.5 bg-white rounded-xl shadow-sm text-[#2C3BEB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#0B1221] tracking-tight leading-tight">Qualifications</h1>
                </div>
                <p class="text-sm text-gray-800 leading-relaxed font-semibold">Update your academic qualifications to get personalized scholarship recommendations.</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start" x-data="qualificationsForm()">
            
            <!-- Left Sticky Navigation Panel -->
            <div class="w-full lg:w-[300px] shrink-0 sticky top-24 z-20 hidden lg:block">
                
                <!-- Navigation -->
                <nav class="space-y-6 relative">
                    <!-- Vertical tracking line -->
                    <div class="absolute left-[15px] top-6 bottom-6 w-0.5 bg-gray-200 z-0 rounded-full"></div>
                    
                    <!-- Link 1 -->
                    <button type="button" @click="scrollTo('section-1')" class="relative z-10 flex items-start gap-4 w-full text-left group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-[3px]"
                             :class="activeSection === 'section-1' ? 'bg-[#2C3BEB] text-white border-[#2C3BEB] shadow-md ring-4 ring-blue-100' : 'bg-white text-gray-400 border-gray-200 group-hover:border-[#2C3BEB] group-hover:text-[#2C3BEB]'">
                            1
                        </div>
                        <div class="mt-1">
                            <p class="text-sm font-bold transition-colors" :class="activeSection === 'section-1' ? 'text-[#2C3BEB]' : 'text-gray-700 group-hover:text-[#2C3BEB]'">Personal Background</p>
                            <p class="text-xs text-gray-500 mt-0.5">Your basic information</p>
                        </div>
                    </button>

                    <!-- Link 2 -->
                    <button type="button" @click="scrollTo('section-2')" class="relative z-10 flex items-start gap-4 w-full text-left group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-[3px]"
                             :class="activeSection === 'section-2' ? 'bg-[#2C3BEB] text-white border-[#2C3BEB] shadow-md ring-4 ring-blue-100' : 'bg-white text-gray-400 border-gray-200 group-hover:border-[#2C3BEB] group-hover:text-[#2C3BEB]'">
                            2
                        </div>
                        <div class="mt-1">
                            <p class="text-sm font-bold transition-colors" :class="activeSection === 'section-2' ? 'text-[#2C3BEB]' : 'text-gray-700 group-hover:text-[#2C3BEB]'">Current Study Status</p>
                            <p class="text-xs text-gray-500 mt-0.5">Your current academic status</p>
                        </div>
                    </button>

                    <!-- Link 3 -->
                    <button type="button" @click="scrollTo('section-3')" class="relative z-10 flex items-start gap-4 w-full text-left group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-[3px]"
                             :class="activeSection === 'section-3' ? 'bg-[#2C3BEB] text-white border-[#2C3BEB] shadow-md ring-4 ring-blue-100' : 'bg-white text-gray-400 border-gray-200 group-hover:border-[#2C3BEB] group-hover:text-[#2C3BEB]'">
                            3
                        </div>
                        <div class="mt-1">
                            <p class="text-sm font-bold transition-colors" :class="activeSection === 'section-3' ? 'text-[#2C3BEB]' : 'text-gray-700 group-hover:text-[#2C3BEB]'">Academic Results</p>
                            <p class="text-xs text-gray-500 mt-0.5">SPM / STPM / MUET / CGPA</p>
                        </div>
                    </button>

                    <!-- Link 4 (Review) -->
                    <button type="button" @click="scrollTo('section-4')" class="relative z-10 flex items-start gap-4 w-full text-left group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-[3px]"
                             :class="activeSection === 'section-4' ? 'bg-[#2C3BEB] text-white border-[#2C3BEB] shadow-md ring-4 ring-blue-100' : 'bg-white text-gray-400 border-gray-200 group-hover:border-[#2C3BEB] group-hover:text-[#2C3BEB]'">
                            4
                        </div>
                        <div class="mt-1">
                            <p class="text-sm font-bold transition-colors" :class="activeSection === 'section-4' ? 'text-[#2C3BEB]' : 'text-gray-700 group-hover:text-[#2C3BEB]'">Review & Submit</p>
                            <p class="text-xs text-gray-500 mt-0.5">Review your qualifications</p>
                        </div>
                    </button>
                </nav>

                <!-- Help Card -->
                <div class="mt-12 bg-blue-50/50 border border-blue-100/60 rounded-2xl p-5 relative overflow-hidden group hover:border-blue-200 transition-colors">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-100 rounded-full blur-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="bg-white p-1.5 rounded-full shadow-sm">
                                <svg class="w-4 h-4 text-[#2C3BEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="font-bold text-blue-950 text-sm tracking-tight">Need Help?</span>
                        </div>
                        <p class="text-[11px] leading-relaxed text-blue-800/80 mb-3 font-medium">Make sure your information is accurate for better recommendations.</p>
                        <a href="#" class="inline-flex items-center justify-center gap-1.5 bg-white border border-blue-200 px-4 py-2 w-full rounded-xl text-xs font-bold text-[#2C3BEB] hover:bg-blue-50 transition-colors shadow-sm">
                            View Guide <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full lg:w-3/4 flex-grow relative">
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-xl shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form id="qualifications-form" method="POST" action="{{ route('qualifications.filter') }}" class="space-y-8">
                    @csrf

                    <fieldset {{ $hasApplied ? 'disabled' : '' }} class="space-y-8">
                        
                        <!-- Section 1: Personal Background -->
                        <div id="section-1" class="form-section bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 scroll-mt-28 relative transition-all duration-300 hover:shadow-md hover:border-blue-100">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-50">
                                <div class="w-10 h-10 rounded-full bg-[#F0F4FF] flex items-center justify-center text-[#2C3BEB]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Personal Background</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <div>
                                    <x-input-label for="current_state" :value="__('Current Resident State')" class="text-gray-700 font-semibold" />
                                    <select id="current_state" name="current_state" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select State</option>
                                        @foreach($malaysianStates as $state)
                                            <option value="{{ $state }}" {{ old('current_state', $qualification->current_state) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="father_birthstate" :value="__('Father\'s Birth State')" class="text-gray-700 font-semibold" />
                                    <select id="father_birthstate" name="father_birthstate" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select State</option>
                                        @foreach($malaysianStates as $state)
                                            <option value="{{ $state }}" {{ old('father_birthstate', $qualification->father_birthstate) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="mother_birthstate" :value="__('Mother\'s Birth State')" class="text-gray-700 font-semibold" />
                                    <select id="mother_birthstate" name="mother_birthstate" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select State</option>
                                        @foreach($malaysianStates as $state)
                                            <option value="{{ $state }}" {{ old('mother_birthstate', $qualification->mother_birthstate) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="years_resident" :value="__('Years Resident in Current State')" class="text-gray-700 font-semibold" />
                                    <x-text-input id="years_resident" name="years_resident" type="number" class="mt-1.5 block w-full rounded-lg text-sm py-2.5" :value="old('years_resident', $qualification->years_resident)" />
                                </div>
                                <div class="col-span-1 md:col-span-2 max-w-md">
                                    <x-input-label for="household_income" :value="__('Household Income (RM)')" class="text-gray-700 font-semibold" />
                                    <x-text-input id="household_income" name="household_income" type="number" step="0.01" x-model="income" class="mt-1.5 block w-full rounded-lg text-sm py-2.5" />
                                    <p class="text-xs font-bold text-[#2C3BEB] mt-2" x-show="category" x-cloak x-text="'Category: ' + category"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Current Study Status -->
                        <div id="section-2" class="form-section bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 scroll-mt-28 relative transition-all duration-300 hover:shadow-md hover:border-blue-100">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-50">
                                <div class="w-10 h-10 rounded-full bg-[#F0F4FF] flex items-center justify-center text-[#2C3BEB]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Current Study Status</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <div>
                                    <x-input-label for="education_level" :value="__('Level Applying For')" class="text-gray-700 font-semibold" />
                                    <select id="education_level" name="education_level" x-model="educationLevel" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select Level</option>
                                        <option value="Diploma" {{ old('education_level', $qualification->education_level) == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                        <option value="Bachelor" {{ old('education_level', $qualification->education_level) == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                                        <option value="Master" {{ old('education_level', $qualification->education_level) == 'Master' ? 'selected' : '' }}>Master</option>
                                        <option value="PhD" {{ old('education_level', $qualification->education_level) == 'PhD' ? 'selected' : '' }}>PhD</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="enrollment_status" :value="__('Enrollment Status')" class="text-gray-700 font-semibold" />
                                    <select id="enrollment_status" name="enrollment_status" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select Status</option>
                                        <option value="full-time" {{ old('enrollment_status', $qualification->enrollment_status) == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                                        <option value="part-time" {{ old('enrollment_status', $qualification->enrollment_status) == 'part-time' ? 'selected' : '' }}>Part-Time</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="field_of_study" :value="__('Field of Study')" class="text-gray-700 font-semibold" />
                                    <x-text-input id="field_of_study" name="field_of_study" type="text" class="mt-1.5 block w-full rounded-lg text-sm py-2.5 uppercase placeholder-normal" :value="old('field_of_study', $qualification->field_of_study)" />
                                </div>
                                <div x-show="educationLevel === 'Bachelor'" x-cloak>
                                    <x-input-label for="year_of_bachelor_study" :value="__('Year of Bachelor Study')" class="text-gray-700 font-semibold" />
                                    <x-text-input id="year_of_bachelor_study" name="year_of_bachelor_study" type="number" class="mt-1.5 block w-full rounded-lg text-sm py-2.5" :value="old('year_of_bachelor_study', $qualification->year_of_bachelor_study)" />
                                </div>
                                <div x-show="educationLevel === 'Bachelor'" x-cloak>
                                    <x-input-label for="current_bachelor_cgpa" :value="__('Current Bachelor CGPA')" class="text-gray-700 font-semibold" />
                                    <x-text-input id="current_bachelor_cgpa" name="current_bachelor_cgpa" type="number" step="0.01" class="mt-1.5 block w-full rounded-lg text-sm py-2.5" :value="old('current_bachelor_cgpa', $qualification->current_bachelor_cgpa)" />
                                </div>
                                <div class="flex items-center md:pt-8 col-span-1 md:col-span-2">
                                    <input id="research_proposal" type="checkbox" name="research_proposal" class="rounded border-gray-300 text-[#2C3BEB] shadow-sm focus:ring-[#2C3BEB] w-4 h-4 cursor-pointer" {{ old('research_proposal', $qualification->research_proposal) ? 'checked' : '' }}>
                                    <label for="research_proposal" class="ml-2.5 block text-sm font-semibold text-gray-700 cursor-pointer select-none">
                                        Approved Research Proposal (For Master/PhD)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Academic Results -->
                        <div id="section-3" class="form-section bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 scroll-mt-28 relative transition-all duration-300 hover:shadow-md hover:border-blue-100">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-50">
                                <div class="w-10 h-10 rounded-full bg-[#F0F4FF] flex items-center justify-center text-[#2C3BEB]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Academic Results</h2>
                            </div>

                            <div class="bg-blue-50/50 border border-blue-100 p-4 mb-8 rounded-xl shadow-sm flex gap-3">
                                <div class="text-[#2C3BEB] mt-0.5"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                <p class="text-sm text-blue-900/80 font-medium leading-relaxed">
                                    <strong class="text-blue-900">Instructions:</strong> If you are an SPM leaver, fill in the SPM section only. If you are an STPM leaver, fill in both SPM and STPM sections.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                                <div>
                                    <x-input-label :value="__('SPM Subjects & Grades')" class="text-gray-800 font-bold mb-3 border-b border-gray-100 pb-2" />
                                    <div class="space-y-3 mt-1" id="spm-container">
                                        @php
                                            $spmResults = is_array($qualification->spm_results) ? $qualification->spm_results : [];
                                            $spmKeys = array_keys($spmResults);
                                            if(empty($spmKeys)) $spmKeys = ['Bahasa Melayu', 'English', 'Sejarah', 'Mathematics'];
                                        @endphp
                                        @foreach($spmKeys as $index => $subject)
                                        <div class="flex flex-col sm:flex-row gap-2.5 spm-row items-center">
                                            <select name="spm_subject_name[]" class="spm-subject-select flex-1 w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white shadow-sm font-medium text-gray-700">
                                                <option value="">Select SPM Subject</option>
                                                @foreach(['Bahasa Melayu', 'English', 'Mathematics', 'Additional Mathematics', 'Sejarah', 'Science', 'Physics', 'Chemistry', 'Biology', 'Prinsip Perakaunan', 'Ekonomi', 'Pendidikan Islam', 'Pendidikan Moral', 'Sains Komputer', 'Reka Cipta', 'Lukisan Kejuruteraan', 'Perniagaan', 'Tasawwur Islam', 'Bahasa Arab', 'Bahasa Cina', 'Bahasa Tamil', 'Bahasa Iban'] as $opt)
                                                    <option value="{{ $opt }}" {{ $subject === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            <div class="flex gap-2 w-full sm:w-auto items-center">
                                                <input type="text" name="spm_subject_grade[]" value="{{ $spmResults[$subject] ?? '' }}" placeholder="Grade" class="spm-subject-grade w-full sm:w-20 font-bold text-center border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] shadow-sm uppercase">
                                                <button type="button" onclick="removeSubjectRow(this)" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Remove Subject">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addSpmSubjectRow()" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-[#2C3BEB] bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Add Subject
                                    </button>
                                </div>
                                <div>
                                    <x-input-label :value="__('STPM Subjects & Grades')" class="text-gray-800 font-bold mb-3 border-b border-gray-100 pb-2" />
                                    <div class="space-y-3 mt-1" id="stpm-container">
                                        @php
                                            $stpmResults = is_array($qualification->stpm_results) ? $qualification->stpm_results : [];
                                            $stpmKeys = array_keys($stpmResults);
                                            if(empty($stpmKeys)) $stpmKeys = ['']; // Initial row
                                        @endphp
                                        @foreach($stpmKeys as $index => $subject)
                                        <div class="flex flex-col sm:flex-row gap-2.5 stpm-row items-center">
                                            <select name="stpm_subject_name[]" class="stpm-subject-select flex-1 w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white shadow-sm font-medium text-gray-700">
                                                <option value="">Select STPM Subject</option>
                                                @foreach(['Pengajian Am', 'Bahasa Melayu', 'Chemistry', 'Physics', 'Biology', 'Mathematics (T)', 'Mathematics (M)', 'Sejarah', 'Geografi', 'Ekonomi', 'Pengajian Perniagaan', 'Perakaunan', 'Kesusasteraan Melayu', 'Seni Visual'] as $opt)
                                                    <option value="{{ $opt }}" {{ $subject === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            <div class="flex gap-2 w-full sm:w-auto items-center">
                                                <input type="text" name="stpm_subject_grade[]" value="{{ $stpmResults[$subject] ?? '' }}" placeholder="Grade" class="stpm-subject-grade w-full sm:w-20 font-bold text-center border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] shadow-sm uppercase">
                                                <button type="button" onclick="removeSubjectRow(this)" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Remove Subject">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addStpmSubjectRow()" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-[#2C3BEB] bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Add Subject
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 mt-10 border-t border-gray-100 pt-8">
                                <div>
                                    <x-input-label for="muet_band" :value="__('MUET Band')" class="text-gray-700 font-semibold" />
                                    <select id="muet_band" name="muet_band" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select Band</option>
                                        @foreach(['1.0', '2.0', '2.5', '3.0', '3.5', '4.0', '4.5', '5.0', '5+'] as $band)
                                            <option value="{{ $band }}" {{ old('muet_band', $qualification->muet_band) == $band ? 'selected' : '' }}>Band {{ $band }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="cefr" :value="__('CEFR English level')" class="text-gray-700 font-semibold" />
                                    <select id="cefr" name="cefr" class="mt-1.5 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-lg shadow-sm text-sm py-2.5">
                                        <option value="">Select CEFR Level</option>
                                        @foreach(['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $level)
                                            <option value="{{ $level }}" {{ old('cefr', $qualification->cefr) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-10 border-t border-gray-100 pt-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-1.5 bg-[#F0F4FF] text-[#2C3BEB] rounded-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">CGPA Records</h3>
                                </div>
                                
                                <div class="space-y-3" id="cgpa-container">
                                    @php
                                        $cgpaRecords = [];
                                        if ($qualification->diploma_cgpa) $cgpaRecords[] = ['level' => 'Diploma', 'value' => $qualification->diploma_cgpa];
                                        if ($qualification->foundation_cgpa) $cgpaRecords[] = ['level' => 'Foundation/Matriculation', 'value' => $qualification->foundation_cgpa];
                                        if ($qualification->stpm_cgpa) $cgpaRecords[] = ['level' => 'STPM', 'value' => $qualification->stpm_cgpa];
                                        if ($qualification->bachelor_cgpa) $cgpaRecords[] = ['level' => 'Bachelor', 'value' => $qualification->bachelor_cgpa];
                                        if ($qualification->master_cgpa) $cgpaRecords[] = ['level' => 'Master', 'value' => $qualification->master_cgpa];
                                        
                                        if (empty($cgpaRecords)) $cgpaRecords[] = ['level' => '', 'value' => ''];
                                    @endphp
                                    @foreach($cgpaRecords as $record)
                                    <div class="flex flex-col sm:flex-row gap-2.5 cgpa-row items-center max-w-2xl">
                                        <select name="cgpa_level[]" class="flex-1 w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white shadow-sm font-medium text-gray-700">
                                            <option value="">Select Education Level</option>
                                            @foreach(['Diploma', 'Foundation/Matriculation', 'STPM', 'Bachelor', 'Master'] as $opt)
                                                <option value="{{ $opt }}" {{ $record['level'] === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                        <div class="flex gap-2 w-full sm:w-auto items-center">
                                            <input type="number" step="0.01" name="cgpa_value[]" value="{{ $record['value'] }}" placeholder="CGPA" class="w-full sm:w-32 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] shadow-sm text-center font-bold">
                                            <button type="button" onclick="removeSubjectRow(this)" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Remove Row">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" onclick="addCgpaRow()" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-[#2C3BEB] bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Add Education Level
                                </button>
                            </div>
                        </div>

                        <!-- Section 4: Review & Submit -->
                        <div id="section-4" class="form-section bg-gray-50 rounded-2xl border-2 border-gray-200 p-6 md:p-8 scroll-mt-28 relative">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-4 shadow-sm border border-green-200">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Review & Submit</h2>
                                <p class="text-sm text-gray-600 max-w-sm mb-6">Review your qualifications below. Once submitted, you'll receive updated scholarship recommendations based on your profile.</p>

                                @if($hasApplied)
                                    <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-5 py-4 text-sm w-full max-w-lg mb-6 shadow-sm text-left">
                                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="font-bold">Qualifications Locked</p>
                                            <p class="mt-1 text-amber-700/90 leading-relaxed">You have already applied to a scholarship. Your qualifications can no longer be changed. <a href="{{ route('applications.index') }}" class="underline font-bold hover:text-amber-900 ml-1">View my applications &rarr;</a></p>
                                        </div>
                                    </div>
                                    <button type="submit" disabled
                                        class="inline-flex items-center gap-2 px-10 py-3.5 text-lg font-bold rounded-xl bg-gray-200 text-gray-400 cursor-not-allowed select-none w-full max-w-md justify-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Filter Qualifications
                                    </button>
                                @else
                                    <button type="submit" class="w-full max-w-md bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-bold text-lg px-10 py-3.5 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                        Filter Qualifications
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qualificationsForm', () => ({
                educationLevel: '{{ old('education_level', $qualification->education_level) }}',
                income: '{{ old('household_income', $qualification->household_income) }}',
                activeSection: 'section-1',
                
                get category() {
                    let val = parseFloat(this.income);
                    if (!val) return '';
                    if (val <= 3401) return 'B40';
                    if (val <= 7971) return 'M40';
                    return 'T20';
                },

                init() {
                    // Setup intersection observer for scroll spy
                    const observer = new IntersectionObserver((entries) => {
                        let mostVisible = null;
                        let maxRatio = 0;
                        entries.forEach(entry => {
                            if (entry.isIntersecting && entry.intersectionRatio > maxRatio) {
                                maxRatio = entry.intersectionRatio;
                                mostVisible = entry.target.id;
                            }
                        });
                        if (mostVisible) {
                            this.activeSection = mostVisible;
                        }
                    }, { rootMargin: '-20% 0px -40% 0px', threshold: [0, 0.2, 0.5, 0.8, 1.0] });
                    
                    document.querySelectorAll('.form-section').forEach(sec => observer.observe(sec));
                },

                scrollTo(id) {
                    const el = document.getElementById(id);
                    if(el) {
                        const y = el.getBoundingClientRect().top + window.scrollY - 100;
                        window.scrollTo({top: y, behavior: 'smooth'});
                        this.activeSection = id;
                    }
                }
            }));
        });

        const SPM_OPTIONS = [
            'Bahasa Melayu', 'English', 'Mathematics', 'Additional Mathematics', 'Sejarah',
            'Science', 'Physics', 'Chemistry', 'Biology', 'Prinsip Perakaunan', 'Ekonomi',
            'Pendidikan Islam', 'Pendidikan Moral', 'Sains Komputer', 'Reka Cipta',
            'Lukisan Kejuruteraan', 'Perniagaan', 'Tasawwur Islam', 'Bahasa Arab',
            'Bahasa Cina', 'Bahasa Tamil', 'Bahasa Iban'
        ];

        const STPM_OPTIONS = [
            'Pengajian Am', 'Bahasa Melayu', 'Chemistry', 'Physics', 'Biology', 
            'Mathematics (T)', 'Mathematics (M)', 'Sejarah', 'Geografi', 'Ekonomi', 
            'Pengajian Perniagaan', 'Perakaunan', 'Kesusasteraan Melayu', 'Seni Visual'
        ];

        function spmSelectHTML() {
            const opts = SPM_OPTIONS.map(o => `<option value="${o}">${o}</option>`).join('');
            return `<option value="">Select SPM Subject</option>${opts}`;
        }

        function stpmSelectHTML() {
            const opts = STPM_OPTIONS.map(o => `<option value="${o}">${o}</option>`).join('');
            return `<option value="">Select STPM Subject</option>${opts}`;
        }

        function addSpmSubjectRow() {
            const container = document.getElementById('spm-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex flex-col sm:flex-row gap-2.5 spm-row items-center';
            newRow.innerHTML = `
                <select name="spm_subject_name[]" class="spm-subject-select flex-1 w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white shadow-sm font-medium text-gray-700">
                    ${spmSelectHTML()}
                </select>
                <div class="flex gap-2 w-full sm:w-auto items-center">
                    <input type="text" name="spm_subject_grade[]" placeholder="Grade" class="spm-subject-grade w-full sm:w-20 font-bold text-center border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] shadow-sm uppercase">
                    <button type="button" onclick="removeSubjectRow(this)" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Remove Subject">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        }

        function addStpmSubjectRow() {
            const container = document.getElementById('stpm-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex flex-col sm:flex-row gap-2.5 stpm-row items-center';
            newRow.innerHTML = `
                <select name="stpm_subject_name[]" class="stpm-subject-select flex-1 w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white shadow-sm font-medium text-gray-700">
                    ${stpmSelectHTML()}
                </select>
                <div class="flex gap-2 w-full sm:w-auto items-center">
                    <input type="text" name="stpm_subject_grade[]" placeholder="Grade" class="stpm-subject-grade w-full sm:w-20 font-bold text-center border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] shadow-sm uppercase">
                    <button type="button" onclick="removeSubjectRow(this)" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Remove Subject">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        }

        function removeSubjectRow(button) {
            button.closest('.flex-col.sm\\:flex-row').remove();
        }

        function addCgpaRow() {
            const container = document.getElementById('cgpa-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex flex-col sm:flex-row gap-2.5 cgpa-row items-center max-w-2xl';
            const opts = ['Diploma', 'Foundation/Matriculation', 'STPM', 'Bachelor', 'Master'].map(o => `<option value="${o}">${o}</option>`).join('');
            newRow.innerHTML = `
                <select name="cgpa_level[]" class="flex-1 w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white shadow-sm font-medium text-gray-700">
                    <option value="">Select Education Level</option>${opts}
                </select>
                <div class="flex gap-2 w-full sm:w-auto items-center">
                    <input type="number" step="0.01" name="cgpa_value[]" placeholder="CGPA" class="w-full sm:w-32 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] shadow-sm text-center font-bold">
                    <button type="button" onclick="removeSubjectRow(this)" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Remove Row">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        }
    </script>
</x-app-layout>
