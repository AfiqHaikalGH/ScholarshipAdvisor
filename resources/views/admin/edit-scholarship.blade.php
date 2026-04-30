<x-app-layout headerTitle="Update Scholarship">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Update Scholarship</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">Update the detailed requirements and information for this
                scholarship.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <p class="font-semibold mb-2">Please fix the following:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $educationLevelRows = old('education_levels');
            if (!$educationLevelRows) {
                $educationLevelRows = $scholarship->scholarshipLevels->map(function ($level) {
                    $decoded = json_decode($level->additional_requirements ?? '', true);
                    $decoded = is_array($decoded) ? $decoded : [];
                    return [
                        'education_level' => $level->education_level,
                        'age_limit' => $level->age_limit,
                        'place_of_study' => $decoded['place_of_study'] ?? '',
                        'min_spm_result' => $decoded['min_spm_result'] ?? '',
                        'spm_subject_name' => array_keys($decoded['spm_subjects'] ?? []),
                        'spm_subject_grade' => array_values($decoded['spm_subjects'] ?? []),
                        'field_of_study' => $decoded['field_of_study'] ?? '',
                        'cefr' => $decoded['cefr'] ?? '',
                        'min_stpm_cgpa' => $decoded['min_stpm_cgpa'] ?? '',
                        'min_foundation_cgpa' => $decoded['min_foundation_cgpa'] ?? '',
                        'min_bachelor_cgpa' => $decoded['min_bachelor_cgpa'] ?? '',
                        'min_master_cgpa' => $decoded['min_master_cgpa'] ?? '',
                        'additional_requirements' => $decoded['additional_requirements'] ?? '',
                    ];
                })->toArray();
            }
            if (empty($educationLevelRows)) {
                $educationLevelRows = [
                    [
                        'education_level' => '',
                        'age_limit' => '',
                        'place_of_study' => '',
                        'min_spm_result' => '',
                        'spm_subject_name' => [''],
                        'spm_subject_grade' => [''],
                        'field_of_study' => '',
                        'cefr' => '',
                        'min_stpm_cgpa' => '',
                        'min_foundation_cgpa' => '',
                        'min_bachelor_cgpa' => '',
                        'min_master_cgpa' => '',
                        'additional_requirements' => '',
                    ]
                ];
            }
            $spmOptions = ['Bahasa Melayu', 'English', 'Mathematics', 'Additional Mathematics', 'Sejarah', 'Science', 'Physics', 'Chemistry', 'Biology', 'Prinsip Perakaunan', 'Ekonomi', 'Pendidikan Islam', 'Pendidikan Moral', 'Sains Komputer', 'Reka Cipta', 'Lukisan Kejuruteraan', 'Perniagaan', 'Tasawwur Islam', 'Bahasa Arab', 'Bahasa Cina', 'Bahasa Tamil', 'Bahasa Iban'];
        @endphp

        <form method="POST" action="{{ route('scholarships.update', $scholarship->id) }}" class="space-y-8"
            id="edit_scholarship_form">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-full">
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Scholarship
                            Name</label>
                        <input type="text" name="name" required value="{{ old('name', $scholarship->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Provider</label>
                        <input type="text" name="provider" value="{{ old('provider', $scholarship->provider) }}"
                            list="providerList"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                        <datalist id="providerList">
                            @foreach($providers as $prov)
                                <option value="{{ $prov }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-span-full md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Amount
                            per year (RM)</label>
                        <input type="number" step="0.01" name="amount_per_year"
                            value="{{ old('amount_per_year', $scholarship->amount_per_year) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div class="col-span-full">
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">{{ old('description', $scholarship->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Application Details</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Start
                            Date</label>
                        <input type="date" name="application_start_date"
                            value="{{ old('application_start_date', $scholarship->application_start_date ? \Carbon\Carbon::parse($scholarship->application_start_date)->format('Y-m-d') : '') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">End
                            Date</label>
                        <input type="date" name="application_end_date"
                            value="{{ old('application_end_date', $scholarship->application_end_date ? \Carbon\Carbon::parse($scholarship->application_end_date)->format('Y-m-d') : '') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Application
                            Status</label>
                        <select name="application_status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                            <option value="Open" {{ old('application_status', $scholarship->application_status) == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ old('application_status', $scholarship->application_status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="Upcoming" {{ old('application_status', $scholarship->application_status) == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">General Requirements</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Citizenship
                            Requirement</label>
                        <input type="text" name="citizenship"
                            value="{{ old('citizenship', $scholarship->citizenship) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Income
                            Category</label>
                        <select name="income_category"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                            <option value="">Any</option>
                            <option value="B40" {{ old('income_category', $scholarship->income_category) == 'B40' ? 'selected' : '' }}>B40</option>
                            <option value="M40" {{ old('income_category', $scholarship->income_category) == 'M40' ? 'selected' : '' }}>M40</option>
                            <option value="T20" {{ old('income_category', $scholarship->income_category) == 'T20' ? 'selected' : '' }}>T20</option>
                        </select>
                    </div>
                    <div class="col-span-full">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Health
                            Requirement</label>
                        <input type="text" name="health_requirement"
                            value="{{ old('health_requirement', $scholarship->health_requirement) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div class="col-span-full space-y-3 mt-2">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="has_other_scholarship_restriction" {{ old('has_other_scholarship_restriction', $scholarship->has_other_scholarship_restriction) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                            <span class="text-sm text-gray-700">Strictly no other scholarship allowed
                                concurrently</span>
                        </label>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="blacklist_status" {{ old('blacklist_status', $scholarship->blacklist_status) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                            <span class="text-sm text-gray-700">Reject blacklisted applicants (e.g. from PTPTN)</span>
                        </label>
                    </div>
                </div>
            </div>

            @php
                // Always decode exactly 4 slots: 0=Diploma, 1=Bachelor, 2=Master, 3=PhD
                $levelSlots = ['Diploma', 'Bachelor', 'Master', 'PhD'];
                $decodedSlots = [];
                foreach ($levelSlots as $i => $label) {
                    $lvl = $scholarship->scholarshipLevels->first(function ($l) use ($label) {
                        return is_array($l->education_levels) && in_array($label, $l->education_levels);
                    });
                    if ($lvl) {
                        $decoded = json_decode($lvl->additional_requirements ?? '', true);
                        $decoded = is_array($decoded) ? $decoded : [];
                        $decodedSlots[$i] = [
                            'min_diploma_cgpa' => $lvl->min_diploma_cgpa ?? '',
                            'min_foundation_cgpa' => $lvl->min_foundation_cgpa ?? '',
                            'min_stpm_cgpa' => $lvl->min_stpm_cgpa ?? '',
                            'min_bachelor_cgpa' => $lvl->min_bachelor_cgpa ?? '',
                            'min_master_cgpa' => $lvl->min_master_cgpa ?? '',
                            'age_limit' => $lvl->age_limit ?? '',
                            'muet_band' => $lvl->muet_band ?? '',
                            'place_of_study' => $decoded['place_of_study'] ?? '',
                            'min_spm_result' => $decoded['min_spm_result'] ?? '',
                            'spm_subject_name' => array_keys($decoded['spm_subjects'] ?? []),
                            'spm_subject_grade' => array_values($decoded['spm_subjects'] ?? []),
                            'field_of_study' => $decoded['field_of_study'] ?? '',
                            'cefr' => $decoded['cefr'] ?? '',
                            'additional_requirements' => $decoded['additional_requirements'] ?? '',
                        ];
                    } else {
                        $decodedSlots[$i] = [
                            'min_diploma_cgpa' => '',
                            'min_foundation_cgpa' => '',
                            'min_stpm_cgpa' => '',
                            'min_bachelor_cgpa' => '',
                            'min_master_cgpa' => '',
                            'age_limit' => '',
                            'muet_band' => '',
                            'place_of_study' => '',
                            'min_spm_result' => '',
                            'spm_subject_name' => [''],
                            'spm_subject_grade' => [''],
                            'field_of_study' => '',
                            'cefr' => '',
                            'additional_requirements' => '',
                        ];
                    }
                    // Override with old() if available
                    if (old('education_levels')) {
                        $old = old('education_levels')[$i] ?? [];
                        $decodedSlots[$i] = array_merge($decodedSlots[$i], $old);
                    }
                }
                $spmOptions = ['Bahasa Melayu', 'English', 'Mathematics', 'Additional Mathematics', 'Sejarah', 'Science', 'Physics', 'Chemistry', 'Biology', 'Prinsip Perakaunan', 'Ekonomi', 'Pendidikan Islam', 'Pendidikan Moral', 'Sains Komputer', 'Reka Cipta', 'Lukisan Kejuruteraan', 'Perniagaan', 'Tasawwur Islam', 'Bahasa Arab', 'Bahasa Cina', 'Bahasa Tamil', 'Bahasa Iban'];
            @endphp



            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Entry Qualification Requirements</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Minimum academic criteria applicants must already hold — set
                        per programme level.</p>
                </div>
                <div class="p-6 space-y-6">

                    {{-- ══ DIPLOMA ══ --}}
                    <div class="education-level-row border border-cyan-200 rounded-xl overflow-hidden mb-6">
                        <div class="flex items-center gap-3 px-5 py-3 bg-cyan-50 border-b border-cyan-200">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold bg-[#0891b2] text-white tracking-wider uppercase">Diploma</span>
                            <p class="text-xs text-gray-500">Applicants' qualifications required for a Diploma
                                scholarship</p>
                        </div>
                        <div class="p-5 space-y-5">
                            <div class="grid grid-cols-1 gap-4 md:w-1/3">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Diploma</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[0][min_diploma_cgpa]"
                                        value="{{ $decodedSlots[0]['min_diploma_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[0][min_spm_result]"
                                        value="{{ $decodedSlots[0]['min_spm_result'] }}"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        @php $dSubjNames = $decodedSlots[0]['spm_subject_name'] ?: [''];
                                        $dSubjGrades = $decodedSlots[0]['spm_subject_grade'] ?: ['']; @endphp
                                        @for($s = 0; $s < max(count($dSubjNames), 1); $s++)
                                            <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                                <select name="education_levels[0][spm_subject_name][]"
                                                    class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                    <option value="">Select SPM Subject</option>
                                                    @foreach($spmOptions as $opt)
                                                        <option value="{{ $opt }}" {{ ($dSubjNames[$s] ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="education_levels[0][spm_subject_grade][]"
                                                    value="{{ $dSubjGrades[$s] ?? '' }}" placeholder="e.g., A+"
                                                    class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                                <button type="button" onclick="removeSpmSubjectRow(this)"
                                                    class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                            </div>
                                        @endfor
                                    </div>
                                    <button type="button" onclick="addSpmSubjectRow(this)"
                                        class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add
                                        Subject</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Age
                                        Limit</label>
                                    <input type="number" min="0" name="education_levels[0][age_limit]"
                                        value="{{ $decodedSlots[0]['age_limit'] }}" placeholder="e.g., 25"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[0][place_of_study]"
                                        value="{{ $decodedSlots[0]['place_of_study'] }}"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @php
                                            $currentField = $decodedSlots[0]['field_of_study'] ?? [];
                                            $currentField = is_array($currentField) ? $currentField : ([$currentField]);
                                        @endphp
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[0][field_of_study][]"
                                                    value="{{ $field }}" {{ in_array($field, $currentField) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                                                <span class="text-gray-700">{{ $field }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">MUET
                                        Band Requirement</label>
                                    <select name="education_levels[0][muet_band]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="Band 1" {{ $decodedSlots[0]['muet_band'] == 'Band 1' ? 'selected' : '' }}>Band 1</option>
                                        <option value="Band 2" {{ $decodedSlots[0]['muet_band'] == 'Band 2' ? 'selected' : '' }}>Band 2</option>
                                        <option value="Band 3" {{ $decodedSlots[0]['muet_band'] == 'Band 3' ? 'selected' : '' }}>Band 3</option>
                                        <option value="Band 4" {{ $decodedSlots[0]['muet_band'] == 'Band 4' ? 'selected' : '' }}>Band 4</option>
                                        <option value="Band 5" {{ $decodedSlots[0]['muet_band'] == 'Band 5' ? 'selected' : '' }}>Band 5</option>
                                        <option value="Band 6" {{ $decodedSlots[0]['muet_band'] == 'Band 6' ? 'selected' : '' }}>Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[0][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1" {{ $decodedSlots[0]['cefr'] == 'A1' ? 'selected' : '' }}>A1
                                        </option>
                                        <option value="A2" {{ $decodedSlots[0]['cefr'] == 'A2' ? 'selected' : '' }}>A2
                                        </option>
                                        <option value="B1" {{ $decodedSlots[0]['cefr'] == 'B1' ? 'selected' : '' }}>B1
                                        </option>
                                        <option value="B2" {{ $decodedSlots[0]['cefr'] == 'B2' ? 'selected' : '' }}>B2
                                        </option>
                                        <option value="C1" {{ $decodedSlots[0]['cefr'] == 'C1' ? 'selected' : '' }}>C1
                                        </option>
                                        <option value="C2" {{ $decodedSlots[0]['cefr'] == 'C2' ? 'selected' : '' }}>C2
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[0][additional_requirements]" rows="3"
                                    placeholder="Enter any specific requirements..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">{{ $decodedSlots[0]['additional_requirements'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ══ BACHELOR ══ --}}
                    <div class="education-level-row border border-indigo-200 rounded-xl overflow-hidden">
                        <div class="flex items-center gap-3 px-5 py-3 bg-indigo-50 border-b border-indigo-200">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold bg-[#2C3BEB] text-white tracking-wider uppercase">Bachelor</span>
                            <p class="text-xs text-gray-500">Applicants' qualifications required for a Bachelor's degree
                                scholarship</p>
                        </div>
                        <div class="p-5 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Diploma</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_diploma_cgpa]"
                                        value="{{ $decodedSlots[1]['min_diploma_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Foundation/Matriculation</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_foundation_cgpa]"
                                        value="{{ $decodedSlots[1]['min_foundation_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — STPM</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_stpm_cgpa]"
                                        value="{{ $decodedSlots[1]['min_stpm_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Bachelor</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_bachelor_cgpa]"
                                        value="{{ $decodedSlots[1]['min_bachelor_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[1][min_spm_result]"
                                        value="{{ $decodedSlots[1]['min_spm_result'] }}"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        @php $bSubjNames = $decodedSlots[1]['spm_subject_name'] ?: [''];
                                        $bSubjGrades = $decodedSlots[1]['spm_subject_grade'] ?: ['']; @endphp
                                        @for($s = 0; $s < max(count($bSubjNames), 1); $s++)
                                            <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                                <select name="education_levels[1][spm_subject_name][]"
                                                    class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                    <option value="">Select SPM Subject</option>
                                                    @foreach($spmOptions as $opt)<option value="{{ $opt }}" {{ ($bSubjNames[$s] ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}
                                                    </option>@endforeach
                                                </select>
                                                <input type="text" name="education_levels[1][spm_subject_grade][]"
                                                    value="{{ $bSubjGrades[$s] ?? '' }}" placeholder="e.g., A+"
                                                    class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                                <button type="button" onclick="removeSpmSubjectRow(this)"
                                                    class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                            </div>
                                        @endfor
                                    </div>
                                    <button type="button" onclick="addSpmSubjectRow(this)"
                                        class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add
                                        Subject</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Age
                                        Limit</label>
                                    <input type="number" min="0" name="education_levels[1][age_limit]"
                                        value="{{ $decodedSlots[1]['age_limit'] }}" placeholder="e.g., 25"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[1][place_of_study]"
                                        value="{{ $decodedSlots[1]['place_of_study'] }}"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @php
                                            $currentField1 = $decodedSlots[1]['field_of_study'] ?? [];
                                            $currentField1 = is_array($currentField1) ? $currentField1 : ([$currentField1]);
                                        @endphp
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[1][field_of_study][]"
                                                    value="{{ $field }}" {{ in_array($field, $currentField1) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                                                <span class="text-gray-700">{{ $field }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">MUET
                                        Band Requirement</label>
                                    <select name="education_levels[1][muet_band]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="Band 1" {{ $decodedSlots[1]['muet_band'] == 'Band 1' ? 'selected' : '' }}>Band 1</option>
                                        <option value="Band 2" {{ $decodedSlots[1]['muet_band'] == 'Band 2' ? 'selected' : '' }}>Band 2</option>
                                        <option value="Band 3" {{ $decodedSlots[1]['muet_band'] == 'Band 3' ? 'selected' : '' }}>Band 3</option>
                                        <option value="Band 4" {{ $decodedSlots[1]['muet_band'] == 'Band 4' ? 'selected' : '' }}>Band 4</option>
                                        <option value="Band 5" {{ $decodedSlots[1]['muet_band'] == 'Band 5' ? 'selected' : '' }}>Band 5</option>
                                        <option value="Band 6" {{ $decodedSlots[1]['muet_band'] == 'Band 6' ? 'selected' : '' }}>Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[1][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1" {{ $decodedSlots[1]['cefr'] == 'A1' ? 'selected' : '' }}>A1
                                        </option>
                                        <option value="A2" {{ $decodedSlots[1]['cefr'] == 'A2' ? 'selected' : '' }}>A2
                                        </option>
                                        <option value="B1" {{ $decodedSlots[1]['cefr'] == 'B1' ? 'selected' : '' }}>B1
                                        </option>
                                        <option value="B2" {{ $decodedSlots[1]['cefr'] == 'B2' ? 'selected' : '' }}>B2
                                        </option>
                                        <option value="C1" {{ $decodedSlots[1]['cefr'] == 'C1' ? 'selected' : '' }}>C1
                                        </option>
                                        <option value="C2" {{ $decodedSlots[1]['cefr'] == 'C2' ? 'selected' : '' }}>C2
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[1][additional_requirements]" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">{{ $decodedSlots[1]['additional_requirements'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ══ MASTER ══ --}}
                    <div class="education-level-row border border-purple-200 rounded-xl overflow-hidden">
                        <div class="flex items-center gap-3 px-5 py-3 bg-purple-50 border-b border-purple-200">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold bg-purple-700 text-white tracking-wider uppercase">Master</span>
                            <p class="text-xs text-gray-500">Applicants' qualifications required for a Master's degree
                                scholarship</p>
                        </div>
                        <div class="p-5 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Diploma</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_diploma_cgpa]"
                                        value="{{ $decodedSlots[2]['min_diploma_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Foundation/Matriculation</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_foundation_cgpa]"
                                        value="{{ $decodedSlots[2]['min_foundation_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — STPM</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_stpm_cgpa]"
                                        value="{{ $decodedSlots[2]['min_stpm_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Bachelor</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_bachelor_cgpa]"
                                        value="{{ $decodedSlots[2]['min_bachelor_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[2][min_spm_result]"
                                        value="{{ $decodedSlots[2]['min_spm_result'] }}"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        @php $mSubjNames = $decodedSlots[2]['spm_subject_name'] ?: [''];
                                        $mSubjGrades = $decodedSlots[2]['spm_subject_grade'] ?: ['']; @endphp
                                        @for($s = 0; $s < max(count($mSubjNames), 1); $s++)
                                            <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                                <select name="education_levels[2][spm_subject_name][]"
                                                    class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                    <option value="">Select SPM Subject</option>
                                                    @foreach($spmOptions as $opt)<option value="{{ $opt }}" {{ ($mSubjNames[$s] ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}
                                                    </option>@endforeach
                                                </select>
                                                <input type="text" name="education_levels[2][spm_subject_grade][]"
                                                    value="{{ $mSubjGrades[$s] ?? '' }}" placeholder="e.g., A+"
                                                    class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                                <button type="button" onclick="removeSpmSubjectRow(this)"
                                                    class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                            </div>
                                        @endfor
                                    </div>
                                    <button type="button" onclick="addSpmSubjectRow(this)"
                                        class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add
                                        Subject</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Age
                                        Limit</label>
                                    <input type="number" min="0" name="education_levels[2][age_limit]"
                                        value="{{ $decodedSlots[2]['age_limit'] }}" placeholder="e.g., 30"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[2][place_of_study]"
                                        value="{{ $decodedSlots[2]['place_of_study'] }}"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @php
                                            $currentField2 = $decodedSlots[2]['field_of_study'] ?? [];
                                            $currentField2 = is_array($currentField2) ? $currentField2 : ([$currentField2]);
                                        @endphp
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[2][field_of_study][]"
                                                    value="{{ $field }}" {{ in_array($field, $currentField2) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                                                <span class="text-gray-700">{{ $field }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">MUET
                                        Band Requirement</label>
                                    <select name="education_levels[2][muet_band]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="Band 1" {{ $decodedSlots[2]['muet_band'] == 'Band 1' ? 'selected' : '' }}>Band 1</option>
                                        <option value="Band 2" {{ $decodedSlots[2]['muet_band'] == 'Band 2' ? 'selected' : '' }}>Band 2</option>
                                        <option value="Band 3" {{ $decodedSlots[2]['muet_band'] == 'Band 3' ? 'selected' : '' }}>Band 3</option>
                                        <option value="Band 4" {{ $decodedSlots[2]['muet_band'] == 'Band 4' ? 'selected' : '' }}>Band 4</option>
                                        <option value="Band 5" {{ $decodedSlots[2]['muet_band'] == 'Band 5' ? 'selected' : '' }}>Band 5</option>
                                        <option value="Band 6" {{ $decodedSlots[2]['muet_band'] == 'Band 6' ? 'selected' : '' }}>Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[2][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1" {{ $decodedSlots[2]['cefr'] == 'A1' ? 'selected' : '' }}>A1
                                        </option>
                                        <option value="A2" {{ $decodedSlots[2]['cefr'] == 'A2' ? 'selected' : '' }}>A2
                                        </option>
                                        <option value="B1" {{ $decodedSlots[2]['cefr'] == 'B1' ? 'selected' : '' }}>B1
                                        </option>
                                        <option value="B2" {{ $decodedSlots[2]['cefr'] == 'B2' ? 'selected' : '' }}>B2
                                        </option>
                                        <option value="C1" {{ $decodedSlots[2]['cefr'] == 'C1' ? 'selected' : '' }}>C1
                                        </option>
                                        <option value="C2" {{ $decodedSlots[2]['cefr'] == 'C2' ? 'selected' : '' }}>C2
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[2][additional_requirements]" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">{{ $decodedSlots[2]['additional_requirements'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ══ PhD ══ --}}
                    <div class="education-level-row border border-rose-200 rounded-xl overflow-hidden">
                        <div class="flex items-center gap-3 px-5 py-3 bg-rose-50 border-b border-rose-200">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold bg-rose-700 text-white tracking-wider uppercase">PhD</span>
                            <p class="text-xs text-gray-500">Applicants' qualifications required for a PhD / Doctorate
                                scholarship</p>
                        </div>
                        <div class="p-5 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Diploma</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[3][min_diploma_cgpa]"
                                        value="{{ $decodedSlots[3]['min_diploma_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Foundation/Matriculation</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[3][min_foundation_cgpa]"
                                        value="{{ $decodedSlots[3]['min_foundation_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — STPM</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[3][min_stpm_cgpa]"
                                        value="{{ $decodedSlots[3]['min_stpm_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Bachelor</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[3][min_bachelor_cgpa]"
                                        value="{{ $decodedSlots[3]['min_bachelor_cgpa'] }}" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Master</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[3][min_master_cgpa]"
                                        value="{{ $decodedSlots[3]['min_master_cgpa'] }}" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[3][min_spm_result]"
                                        value="{{ $decodedSlots[3]['min_spm_result'] }}"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        @php $pSubjNames = $decodedSlots[3]['spm_subject_name'] ?: [''];
                                        $pSubjGrades = $decodedSlots[3]['spm_subject_grade'] ?: ['']; @endphp
                                        @for($s = 0; $s < max(count($pSubjNames), 1); $s++)
                                            <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                                <select name="education_levels[3][spm_subject_name][]"
                                                    class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                    <option value="">Select SPM Subject</option>
                                                    @foreach($spmOptions as $opt)<option value="{{ $opt }}" {{ ($pSubjNames[$s] ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}
                                                    </option>@endforeach
                                                </select>
                                                <input type="text" name="education_levels[3][spm_subject_grade][]"
                                                    value="{{ $pSubjGrades[$s] ?? '' }}" placeholder="e.g., A+"
                                                    class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                                <button type="button" onclick="removeSpmSubjectRow(this)"
                                                    class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                            </div>
                                        @endfor
                                    </div>
                                    <button type="button" onclick="addSpmSubjectRow(this)"
                                        class="mt-2 text-xs font-semibold text-[#2C3BEB] hover:text-[#2130d4]">+ Add
                                        Subject</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Age
                                        Limit</label>
                                    <input type="number" min="0" name="education_levels[3][age_limit]"
                                        value="{{ $decodedSlots[3]['age_limit'] }}" placeholder="e.g., 35"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[3][place_of_study]"
                                        value="{{ $decodedSlots[3]['place_of_study'] }}"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @php
                                            $currentField3 = $decodedSlots[3]['field_of_study'] ?? [];
                                            $currentField3 = is_array($currentField3) ? $currentField3 : ([$currentField3]);
                                        @endphp
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[3][field_of_study][]"
                                                    value="{{ $field }}" {{ in_array($field, $currentField3) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                                                <span class="text-gray-700">{{ $field }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">MUET
                                        Band Requirement</label>
                                    <select name="education_levels[3][muet_band]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="Band 1" {{ $decodedSlots[3]['muet_band'] == 'Band 1' ? 'selected' : '' }}>Band 1</option>
                                        <option value="Band 2" {{ $decodedSlots[3]['muet_band'] == 'Band 2' ? 'selected' : '' }}>Band 2</option>
                                        <option value="Band 3" {{ $decodedSlots[3]['muet_band'] == 'Band 3' ? 'selected' : '' }}>Band 3</option>
                                        <option value="Band 4" {{ $decodedSlots[3]['muet_band'] == 'Band 4' ? 'selected' : '' }}>Band 4</option>
                                        <option value="Band 5" {{ $decodedSlots[3]['muet_band'] == 'Band 5' ? 'selected' : '' }}>Band 5</option>
                                        <option value="Band 6" {{ $decodedSlots[3]['muet_band'] == 'Band 6' ? 'selected' : '' }}>Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[3][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1" {{ $decodedSlots[3]['cefr'] == 'A1' ? 'selected' : '' }}>A1
                                        </option>
                                        <option value="A2" {{ $decodedSlots[3]['cefr'] == 'A2' ? 'selected' : '' }}>A2
                                        </option>
                                        <option value="B1" {{ $decodedSlots[3]['cefr'] == 'B1' ? 'selected' : '' }}>B1
                                        </option>
                                        <option value="B2" {{ $decodedSlots[3]['cefr'] == 'B2' ? 'selected' : '' }}>B2
                                        </option>
                                        <option value="C1" {{ $decodedSlots[3]['cefr'] == 'C1' ? 'selected' : '' }}>C1
                                        </option>
                                        <option value="C2" {{ $decodedSlots[3]['cefr'] == 'C2' ? 'selected' : '' }}>C2
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[3][additional_requirements]" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">{{ $decodedSlots[3]['additional_requirements'] }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Bond Information</h2>
                </div>
                <div class="p-6">
                    <label class="flex items-center gap-3 mb-6">
                        <input type="checkbox" name="bond_required" id="bond_required" onchange="toggleBondFields()" {{ old('bond_required', $scholarship->bond_required) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                        <span class="text-sm font-semibold text-gray-800">A bond is required for this scholarship</span>
                    </label>
                    <div id="bond_details"
                        class="{{ old('bond_required', $scholarship->bond_required) ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-2 gap-6 pl-7 border-l-2 border-[#2C3BEB] ml-1.5 mt-2 transition-all">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Bond
                                Duration (Years)</label>
                            <input type="number" name="bond_duration"
                                value="{{ old('bond_duration', $scholarship->bond_duration) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Bond
                                Organization</label>
                            <input type="text" name="bond_organization"
                                value="{{ old('bond_organization', $scholarship->bond_organization) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('scholarship.info') }}"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-[#2C3BEB] text-white font-medium text-sm hover:bg-[#2130d4] transition-colors shadow-sm">
                    Update Scholarship
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('edit_scholarship_form').addEventListener('submit', function (event) {
            // Warn on duplicate SPM subjects within a section
            const rows = document.querySelectorAll('.education-level-row');
            for (const row of rows) {
                const subjects = Array.from(row.querySelectorAll('.spm-subject-select'))
                    .map((s) => s.value).filter((v) => v !== '');
                if (new Set(subjects).size !== subjects.length) {
                    event.preventDefault();
                    alert('Duplicate SPM subjects in the same section are not allowed.');
                    return;
                }
            }
        });

        function toggleBondFields() {
            const isChecked = document.getElementById('bond_required').checked;
            const container = document.getElementById('bond_details');
            if (isChecked) container.classList.remove('hidden');
            else container.classList.add('hidden');
        }

        const SPM_OPTIONS = [
            'Bahasa Melayu', 'English', 'Mathematics', 'Additional Mathematics', 'Sejarah',
            'Science', 'Physics', 'Chemistry', 'Biology', 'Prinsip Perakaunan', 'Ekonomi',
            'Pendidikan Islam', 'Pendidikan Moral', 'Sains Komputer', 'Reka Cipta',
            'Lukisan Kejuruteraan', 'Perniagaan', 'Tasawwur Islam', 'Bahasa Arab',
            'Bahasa Cina', 'Bahasa Tamil', 'Bahasa Iban'
        ];

        function spmSelectHTML() {
            const opts = SPM_OPTIONS.map(o => `<option value="${o}">${o}</option>`).join('');
            return `<option value="">Select SPM Subject</option>${opts}`;
        }

        function addSpmSubjectRow(button) {
            const section = button.closest('.education-level-row');
            const container = section.querySelector('[data-spm-container]');
            const existingSelect = container.querySelector('.spm-subject-select');
            const match = existingSelect ? existingSelect.name.match(/education_levels\[(\d+)\]/) : null;
            const idx = match ? match[1] : '0';
            const newRow = document.createElement('div');
            newRow.className = 'flex flex-col sm:flex-row gap-2 spm-row';
            newRow.innerHTML = `
                <select name="education_levels[${idx}][spm_subject_name][]" class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                    ${spmSelectHTML()}
                </select>
                <input type="text" name="education_levels[${idx}][spm_subject_grade][]" placeholder="e.g., A+" class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                <button type="button" onclick="removeSpmSubjectRow(this)" class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeSpmSubjectRow(button) {
            const section = button.closest('.education-level-row');
            const container = section.querySelector('[data-spm-container]');
            if (container.querySelectorAll('.spm-row').length <= 1) {
                alert('At least one SPM subject row must remain.');
                return;
            }
            button.closest('.spm-row').remove();
        }
    </script>

</x-app-layout>