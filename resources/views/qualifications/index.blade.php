<x-app-layout headerTitle="Qualifications">
    @php
        $malaysianStates = [
            'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 
            'Pulau Pinang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 
            'Wilayah Persekutuan Kuala Lumpur', 'Wilayah Persekutuan Putrajaya', 'Wilayah Persekutuan Labuan', 
            'Outside Malaysia'
        ];
    @endphp
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center mb-10 gap-2">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Qualifications</h1>
            <p class="text-base text-gray-500 max-w-2xl">Update your academic qualifications to get personalized scholarship recommendations.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <form method="POST" action="{{ route('qualifications.filter') }}" class="space-y-8" x-data="{ educationLevel: '{{ old('education_level', $qualification->education_level) }}' }">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
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

                <!-- Personal Background Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Personal Background</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="current_state" :value="__('Current Resident State')" />
                            <select id="current_state" name="current_state" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select State</option>
                                @foreach($malaysianStates as $state)
                                    <option value="{{ $state }}" {{ old('current_state', $qualification->current_state) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="father_birthstate" :value="__('Father\'s Birth State')" />
                            <select id="father_birthstate" name="father_birthstate" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select State</option>
                                @foreach($malaysianStates as $state)
                                    <option value="{{ $state }}" {{ old('father_birthstate', $qualification->father_birthstate) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="mother_birthstate" :value="__('Mother\'s Birth State')" />
                            <select id="mother_birthstate" name="mother_birthstate" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select State</option>
                                @foreach($malaysianStates as $state)
                                    <option value="{{ $state }}" {{ old('mother_birthstate', $qualification->mother_birthstate) === $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="years_resident" :value="__('Years Resident in Current State')" />
                            <x-text-input id="years_resident" name="years_resident" type="number" class="mt-1 block w-full" :value="old('years_resident', $qualification->years_resident)" />
                        </div>
                        <div x-data="{
                            income: '{{ old('household_income', $qualification->household_income) }}',
                            get category() {
                                let val = parseFloat(this.income);
                                if (!val) return '';
                                if (val <= 3401) return 'B40';
                                if (val <= 7971) return 'M40';
                                return 'T20';
                            }
                        }">
                            <x-input-label for="household_income" :value="__('Household Income (RM)')" />
                            <x-text-input id="household_income" name="household_income" type="number" step="0.01" x-model="income" class="mt-1 block w-full" />
                            <p class="text-xs text-blue-600 font-semibold mt-1" x-show="category" x-text="'Category: ' + category"></p>
                        </div>
                    </div>
                </div>

                <!-- Study Status Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Current Study Status</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="education_level" :value="__('Education Level')" />
                            <select id="education_level" name="education_level" x-model="educationLevel" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select Level</option>
                                <option value="Foundation/Matriculation" {{ old('education_level', $qualification->education_level) == 'Foundation/Matriculation' ? 'selected' : '' }}>Foundation/Matriculation</option>
                                <option value="Diploma" {{ old('education_level', $qualification->education_level) == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="Bachelor" {{ old('education_level', $qualification->education_level) == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                                <option value="Master" {{ old('education_level', $qualification->education_level) == 'Master' ? 'selected' : '' }}>Master</option>
                                <option value="PhD" {{ old('education_level', $qualification->education_level) == 'PhD' ? 'selected' : '' }}>PhD</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="enrollment_status" :value="__('Enrollment Status')" />
                            <select id="enrollment_status" name="enrollment_status" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select Status</option>
                                <option value="full-time" {{ old('enrollment_status', $qualification->enrollment_status) == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                                <option value="part-time" {{ old('enrollment_status', $qualification->enrollment_status) == 'part-time' ? 'selected' : '' }}>Part-Time</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="field_of_study" :value="__('Field of Study')" />
                            <x-text-input id="field_of_study" name="field_of_study" type="text" class="mt-1 block w-full" :value="old('field_of_study', $qualification->field_of_study)" />
                        </div>
                        <div x-show="educationLevel === 'Bachelor'" x-cloak>
                            <x-input-label for="year_of_bachelor_study" :value="__('Year of Bachelor Study')" />
                            <x-text-input id="year_of_bachelor_study" name="year_of_bachelor_study" type="number" class="mt-1 block w-full" :value="old('year_of_bachelor_study', $qualification->year_of_bachelor_study)" />
                        </div>
                        <div x-show="educationLevel === 'Bachelor'" x-cloak>
                            <x-input-label for="current_bachelor_cgpa" :value="__('Current Bachelor CGPA')" />
                            <x-text-input id="current_bachelor_cgpa" name="current_bachelor_cgpa" type="number" step="0.01" class="mt-1 block w-full" :value="old('current_bachelor_cgpa', $qualification->current_bachelor_cgpa)" />
                        </div>
                        <div class="flex items-center pt-8">
                            <input id="research_proposal" type="checkbox" name="research_proposal" class="rounded border-gray-300 text-[#2C3BEB] shadow-sm focus:ring-[#2C3BEB]" {{ old('research_proposal', $qualification->research_proposal) ? 'checked' : '' }}>
                            <label for="research_proposal" class="ml-2 block text-sm text-gray-900">
                                Approved Research Proposal (For Master/PhD)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Academic Results Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Academic Results</h2>
                    <div class="bg-blue-50 border-l-4 border-[#2C3BEB] p-4 mb-6 rounded-r-md">
                        <p class="text-sm text-blue-800">
                            <strong>Instructions:</strong> If you are an SPM leaver, fill in the SPM section only. If you are an STPM leaver, fill in both SPM and STPM sections.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label :value="__('SPM Subjects & Grades')" />
                            <div class="space-y-2 mt-1" id="spm-container">
                                @php
                                    $spmResults = is_array($qualification->spm_results) ? $qualification->spm_results : [];
                                    $spmKeys = array_keys($spmResults);
                                    if(empty($spmKeys)) $spmKeys = ['Bahasa Melayu', 'English', 'Sejarah', 'Mathematics'];
                                @endphp
                                @foreach($spmKeys as $index => $subject)
                                <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                    <select name="spm_subject_name[]" class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Select SPM Subject</option>
                                        @foreach(['Bahasa Melayu', 'English', 'Mathematics', 'Additional Mathematics', 'Sejarah', 'Science', 'Physics', 'Chemistry', 'Biology', 'Prinsip Perakaunan', 'Ekonomi', 'Pendidikan Islam', 'Pendidikan Moral', 'Sains Komputer', 'Reka Cipta', 'Lukisan Kejuruteraan', 'Perniagaan', 'Tasawwur Islam', 'Bahasa Arab', 'Bahasa Cina', 'Bahasa Tamil', 'Bahasa Iban'] as $opt)
                                            <option value="{{ $opt }}" {{ $subject === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="spm_subject_grade[]" value="{{ $spmResults[$subject] ?? '' }}" placeholder="e.g., A+" class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                    <button type="button" onclick="removeSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addSpmSubjectRow()" class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add Subject</button>
                        </div>
                        <div>
                            <x-input-label :value="__('STPM Subjects & Grades')" />
                            <div class="space-y-2 mt-1" id="stpm-container">
                                @php
                                    $stpmResults = is_array($qualification->stpm_results) ? $qualification->stpm_results : [];
                                    $stpmKeys = array_keys($stpmResults);
                                    if(empty($stpmKeys)) $stpmKeys = ['']; // Initial row
                                @endphp
                                @foreach($stpmKeys as $index => $subject)
                                <div class="flex flex-col sm:flex-row gap-2 stpm-row">
                                    <select name="stpm_subject_name[]" class="stpm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Select STPM Subject</option>
                                        @foreach(['Pengajian Am', 'Bahasa Melayu', 'Chemistry', 'Physics', 'Biology', 'Mathematics (T)', 'Mathematics (M)', 'Sejarah', 'Geografi', 'Ekonomi', 'Pengajian Perniagaan', 'Perakaunan', 'Kesusasteraan Melayu', 'Seni Visual'] as $opt)
                                            <option value="{{ $opt }}" {{ $subject === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="stpm_subject_grade[]" value="{{ $stpmResults[$subject] ?? '' }}" placeholder="e.g., A" class="stpm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                    <button type="button" onclick="removeSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addStpmSubjectRow()" class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add Subject</button>
                        </div>
                        <div>
                            <x-input-label for="muet_band" :value="__('MUET Band')" />
                            <select id="muet_band" name="muet_band" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select Band</option>
                                @foreach(['1.0', '2.0', '2.5', '3.0', '3.5', '4.0', '4.5', '5.0', '5+'] as $band)
                                    <option value="{{ $band }}" {{ old('muet_band', $qualification->muet_band) == $band ? 'selected' : '' }}>Band {{ $band }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="cefr" :value="__('CEFR English level')" />
                            <select id="cefr" name="cefr" class="mt-1 block w-full border-gray-300 focus:border-[#2C3BEB] focus:ring-[#2C3BEB] rounded-md shadow-sm">
                                <option value="">Select CEFR Level</option>
                                @foreach(['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $level)
                                    <option value="{{ $level }}" {{ old('cefr', $qualification->cefr) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-medium text-gray-700 mt-6 mb-3">CGPA Records</h3>
                    <div class="space-y-2" id="cgpa-container">
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
                        <div class="flex flex-col sm:flex-row gap-2 cgpa-row">
                            <select name="cgpa_level[]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                <option value="">Select Education Level</option>
                                @foreach(['Diploma', 'Foundation/Matriculation', 'STPM', 'Bachelor', 'Master'] as $opt)
                                    <option value="{{ $opt }}" {{ $record['level'] === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            <input type="number" step="0.01" name="cgpa_value[]" value="{{ $record['value'] }}" placeholder="e.g. 3.50" class="w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                            <button type="button" onclick="removeSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addCgpaRow()" class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add Education Level</button>
                </div>

                <div class="flex items-center justify-center gap-4 pt-4 border-t border-gray-50">
                    <x-primary-button class="!bg-[#2C3BEB] hover:!bg-[#2130d4] text-lg px-8 py-3">{{ __('Filter Qualifications') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
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
            newRow.className = 'flex flex-col sm:flex-row gap-2 spm-row';
            newRow.innerHTML = `
                <select name="spm_subject_name[]" class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                    ${spmSelectHTML()}
                </select>
                <input type="text" name="spm_subject_grade[]" placeholder="e.g., A+" class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                <button type="button" onclick="removeSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function addStpmSubjectRow() {
            const container = document.getElementById('stpm-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex flex-col sm:flex-row gap-2 stpm-row';
            newRow.innerHTML = `
                <select name="stpm_subject_name[]" class="stpm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                    ${stpmSelectHTML()}
                </select>
                <input type="text" name="stpm_subject_grade[]" placeholder="e.g., A" class="stpm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                <button type="button" onclick="removeSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeSubjectRow(button) {
            button.closest('.flex').remove();
        }

        function addCgpaRow() {
            const container = document.getElementById('cgpa-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex flex-col sm:flex-row gap-2 cgpa-row';
            const opts = ['Diploma', 'Foundation/Matriculation', 'STPM', 'Bachelor', 'Master'].map(o => `<option value="${o}">${o}</option>`).join('');
            newRow.innerHTML = `
                <select name="cgpa_level[]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                    <option value="">Select Education Level</option>${opts}
                </select>
                <input type="number" step="0.01" name="cgpa_value[]" placeholder="e.g. 3.50" class="w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                <button type="button" onclick="removeSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
            `;
            container.appendChild(newRow);
        }
    </script>
</x-app-layout>
