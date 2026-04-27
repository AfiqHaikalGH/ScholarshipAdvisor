<x-app-layout headerTitle="Create Scholarship">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Create Scholarship</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">Enter the detailed requirements and information for a new scholarship offering.</p>
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

        <form method="POST" action="{{ route('scholarships.store') }}" class="space-y-8" id="create_scholarship_form">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-full">
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Scholarship
                            Name</label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Provider</label>
                        <input type="text" name="provider" list="providerList"
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
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div class="col-span-full">
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Description</label>
                        <textarea name="description" rows="4"
                            placeholder="Enter full description of the scholarship, eligibility, benefits, and any other relevant information..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 2: Application Details -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Application Details</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Start
                            Date</label>
                        <input type="date" name="application_start_date"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">End
                            Date</label>
                        <input type="date" name="application_end_date"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Application
                            Status</label>
                        <select name="application_status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                            <option value="Upcoming">Upcoming</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 3: General Requirements -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">General Requirements</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Citizenship
                            Requirement</label>
                        <input type="text" name="citizenship" placeholder="e.g., Malaysian"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Income
                            Category</label>
                        <select name="income_category"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                            <option value="">Any</option>
                            <option value="B40">B40</option>
                            <option value="M40">M40</option>
                            <option value="T20">T20</option>
                        </select>
                    </div>
                    <div class="col-span-full">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Health
                            Requirement</label>
                        <input type="text" name="health_requirement" placeholder="e.g., Excellent visually"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>

                    <div class="col-span-full space-y-3 mt-2">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="has_other_scholarship_restriction"
                                class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                            <span class="text-sm text-gray-700">Strictly no other scholarship allowed
                                concurrently</span>
                        </label>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="blacklist_status"
                                class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                            <span class="text-sm text-gray-700">Reject blacklisted applicants (e.g. from PTPTN)</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- Section 4: Entry Qualification Requirements -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Entry Qualification Requirements</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Minimum academic criteria applicants must already hold — set
                        per programme level.</p>
                </div>
                <div class="p-6 space-y-6">

                    {{-- ══ DIPLOMA ══ --}}
                    <div class="education-level-row border border-cyan-200 rounded-xl overflow-hidden">
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
                                        name="education_levels[0][min_diploma_cgpa]" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[0][min_spm_result]"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                            <select name="education_levels[0][spm_subject_name][]"
                                                class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                <option value="">Select SPM Subject</option>
                                                <option value="Bahasa Melayu">Bahasa Melayu</option>
                                                <option value="English">English</option>
                                                <option value="Mathematics">Mathematics</option>
                                                <option value="Additional Mathematics">Additional Mathematics</option>
                                                <option value="Sejarah">Sejarah</option>
                                                <option value="Science">Science</option>
                                                <option value="Physics">Physics</option>
                                                <option value="Chemistry">Chemistry</option>
                                                <option value="Biology">Biology</option>
                                                <option value="Prinsip Perakaunan">Prinsip Perakaunan</option>
                                                <option value="Ekonomi">Ekonomi</option>
                                                <option value="Pendidikan Islam">Pendidikan Islam</option>
                                                <option value="Pendidikan Moral">Pendidikan Moral</option>
                                                <option value="Sains Komputer">Sains Komputer</option>
                                                <option value="Reka Cipta">Reka Cipta</option>
                                                <option value="Lukisan Kejuruteraan">Lukisan Kejuruteraan</option>
                                                <option value="Perniagaan">Perniagaan</option>
                                                <option value="Tasawwur Islam">Tasawwur Islam</option>
                                                <option value="Bahasa Arab">Bahasa Arab</option>
                                                <option value="Bahasa Cina">Bahasa Cina</option>
                                                <option value="Bahasa Tamil">Bahasa Tamil</option>
                                                <option value="Bahasa Iban">Bahasa Iban</option>
                                            </select>
                                            <input type="text" name="education_levels[0][spm_subject_grade][]"
                                                placeholder="e.g., A+"
                                                class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                            <button type="button" onclick="removeSpmSubjectRow(this)"
                                                class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                        </div>
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
                                        placeholder="e.g., 25"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[0][place_of_study]"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[0][field_of_study][]"
                                                    value="{{ $field }}"
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
                                        <option value="Band 1">Band 1</option>
                                        <option value="Band 2">Band 2</option>
                                        <option value="Band 3">Band 3</option>
                                        <option value="Band 4">Band 4</option>
                                        <option value="Band 5">Band 5</option>
                                        <option value="Band 6">Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[0][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1">A1</option>
                                        <option value="A2">A2</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[0][additional_requirements]" rows="3"
                                    placeholder="Enter any specific requirements..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]"></textarea>
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Diploma</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_diploma_cgpa]" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Foundation</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_foundation_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — STPM</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_stpm_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Bachelor</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[1][min_bachelor_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[1][min_spm_result]"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                            <select name="education_levels[1][spm_subject_name][]"
                                                class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                <option value="">Select SPM Subject</option>
                                                <option value="Bahasa Melayu">Bahasa Melayu</option>
                                                <option value="English">English</option>
                                                <option value="Mathematics">Mathematics</option>
                                                <option value="Additional Mathematics">Additional Mathematics</option>
                                                <option value="Sejarah">Sejarah</option>
                                                <option value="Science">Science</option>
                                                <option value="Physics">Physics</option>
                                                <option value="Chemistry">Chemistry</option>
                                                <option value="Biology">Biology</option>
                                                <option value="Prinsip Perakaunan">Prinsip Perakaunan</option>
                                                <option value="Ekonomi">Ekonomi</option>
                                                <option value="Pendidikan Islam">Pendidikan Islam</option>
                                                <option value="Pendidikan Moral">Pendidikan Moral</option>
                                                <option value="Sains Komputer">Sains Komputer</option>
                                                <option value="Reka Cipta">Reka Cipta</option>
                                                <option value="Lukisan Kejuruteraan">Lukisan Kejuruteraan</option>
                                                <option value="Perniagaan">Perniagaan</option>
                                                <option value="Tasawwur Islam">Tasawwur Islam</option>
                                                <option value="Bahasa Arab">Bahasa Arab</option>
                                                <option value="Bahasa Cina">Bahasa Cina</option>
                                                <option value="Bahasa Tamil">Bahasa Tamil</option>
                                                <option value="Bahasa Iban">Bahasa Iban</option>
                                            </select>
                                            <input type="text" name="education_levels[1][spm_subject_grade][]"
                                                placeholder="e.g., A+"
                                                class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                            <button type="button" onclick="removeSpmSubjectRow(this)"
                                                class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                        </div>
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
                                        placeholder="e.g., 25"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[1][place_of_study]"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[1][field_of_study][]"
                                                    value="{{ $field }}"
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
                                        <option value="Band 1">Band 1</option>
                                        <option value="Band 2">Band 2</option>
                                        <option value="Band 3">Band 3</option>
                                        <option value="Band 4">Band 4</option>
                                        <option value="Band 5">Band 5</option>
                                        <option value="Band 6">Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[1][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1">A1</option>
                                        <option value="A2">A2</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[1][additional_requirements]" rows="3"
                                    placeholder="Enter any Bachelor-specific requirements..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]"></textarea>
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
                                        name="education_levels[2][min_diploma_cgpa]" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Foundation</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_foundation_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — STPM</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_stpm_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Bachelor</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_bachelor_cgpa]" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[2][min_spm_result]"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                            <select name="education_levels[2][spm_subject_name][]"
                                                class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                <option value="">Select SPM Subject</option>
                                                <option value="Bahasa Melayu">Bahasa Melayu</option>
                                                <option value="English">English</option>
                                                <option value="Mathematics">Mathematics</option>
                                                <option value="Additional Mathematics">Additional Mathematics</option>
                                                <option value="Sejarah">Sejarah</option>
                                                <option value="Science">Science</option>
                                                <option value="Physics">Physics</option>
                                                <option value="Chemistry">Chemistry</option>
                                                <option value="Biology">Biology</option>
                                                <option value="Prinsip Perakaunan">Prinsip Perakaunan</option>
                                                <option value="Ekonomi">Ekonomi</option>
                                                <option value="Pendidikan Islam">Pendidikan Islam</option>
                                                <option value="Pendidikan Moral">Pendidikan Moral</option>
                                                <option value="Sains Komputer">Sains Komputer</option>
                                                <option value="Reka Cipta">Reka Cipta</option>
                                                <option value="Lukisan Kejuruteraan">Lukisan Kejuruteraan</option>
                                                <option value="Perniagaan">Perniagaan</option>
                                                <option value="Tasawwur Islam">Tasawwur Islam</option>
                                                <option value="Bahasa Arab">Bahasa Arab</option>
                                                <option value="Bahasa Cina">Bahasa Cina</option>
                                                <option value="Bahasa Tamil">Bahasa Tamil</option>
                                                <option value="Bahasa Iban">Bahasa Iban</option>
                                            </select>
                                            <input type="text" name="education_levels[2][spm_subject_grade][]"
                                                placeholder="e.g., A+"
                                                class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                            <button type="button" onclick="removeSpmSubjectRow(this)"
                                                class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                        </div>
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
                                        placeholder="e.g., 30"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[2][place_of_study]"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @foreach(['Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[2][field_of_study][]"
                                                    value="{{ $field }}"
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
                                        <option value="Band 1">Band 1</option>
                                        <option value="Band 2">Band 2</option>
                                        <option value="Band 3">Band 3</option>
                                        <option value="Band 4">Band 4</option>
                                        <option value="Band 5">Band 5</option>
                                        <option value="Band 6">Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[2][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1">A1</option>
                                        <option value="A2">A2</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[2][additional_requirements]" rows="3"
                                    placeholder="Enter any Master-specific requirements..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]"></textarea>
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Foundation/Matriculation</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_foundation_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — STPM</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_stpm_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Bachelor</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_bachelor_cgpa]" placeholder="e.g., 3.00"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Min
                                        CGPA — Master</label>
                                    <input type="number" step="0.01" min="0" max="4.00"
                                        name="education_levels[2][min_master_cgpa]" placeholder="e.g., 3.50"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Minimum
                                        Overall SPM Result</label>
                                    <input type="text" name="education_levels[2][min_spm_result]"
                                        placeholder="e.g., 5A 2B or 3 Credits"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">SPM
                                        Grade Requirements</label>
                                    <div class="space-y-2" data-spm-container>
                                        <div class="flex flex-col sm:flex-row gap-2 spm-row">
                                            <select name="education_levels[2][spm_subject_name][]"
                                                class="spm-subject-select flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                                <option value="">Select SPM Subject</option>
                                                <option value="Bahasa Melayu">Bahasa Melayu</option>
                                                <option value="English">English</option>
                                                <option value="Mathematics">Mathematics</option>
                                                <option value="Additional Mathematics">Additional Mathematics</option>
                                                <option value="Sejarah">Sejarah</option>
                                                <option value="Science">Science</option>
                                                <option value="Physics">Physics</option>
                                                <option value="Chemistry">Chemistry</option>
                                                <option value="Biology">Biology</option>
                                                <option value="Prinsip Perakaunan">Prinsip Perakaunan</option>
                                                <option value="Ekonomi">Ekonomi</option>
                                                <option value="Pendidikan Islam">Pendidikan Islam</option>
                                                <option value="Pendidikan Moral">Pendidikan Moral</option>
                                                <option value="Sains Komputer">Sains Komputer</option>
                                                <option value="Reka Cipta">Reka Cipta</option>
                                                <option value="Lukisan Kejuruteraan">Lukisan Kejuruteraan</option>
                                                <option value="Perniagaan">Perniagaan</option>
                                                <option value="Tasawwur Islam">Tasawwur Islam</option>
                                                <option value="Bahasa Arab">Bahasa Arab</option>
                                                <option value="Bahasa Cina">Bahasa Cina</option>
                                                <option value="Bahasa Tamil">Bahasa Tamil</option>
                                                <option value="Bahasa Iban">Bahasa Iban</option>
                                            </select>
                                            <input type="text" name="education_levels[2][spm_subject_grade][]"
                                                placeholder="e.g., A+"
                                                class="spm-subject-grade w-full sm:w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                            <button type="button" onclick="removeSpmSubjectRow(this)"
                                                class="px-3 py-2 text-red-500 hover:text-red-700 text-sm">Remove</button>
                                        </div>
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
                                        placeholder="e.g., 35"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place
                                        of Study</label>
                                    <input type="text" name="education_levels[3][place_of_study]"
                                        placeholder="e.g., Local University"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Field
                                        of Study</label>
                                    <div
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white overflow-y-auto max-h-40 space-y-2">
                                        @foreach(['Any', 'Computer Science & IT', 'Engineering', 'Business & Finance', 'Medicine & Healthcare', 'Law', 'Arts & Design', 'Education', 'Sciences', 'STEM', 'Islamic Studies'] as $field)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="education_levels[3][field_of_study][]"
                                                    value="{{ $field }}"
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
                                        <option value="Band 1">Band 1</option>
                                        <option value="Band 2">Band 2</option>
                                        <option value="Band 3">Band 3</option>
                                        <option value="Band 4">Band 4</option>
                                        <option value="Band 5">Band 5</option>
                                        <option value="Band 6">Band 6</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CEFR
                                        English Requirement</label>
                                    <select name="education_levels[3][cefr]"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                                        <option value="">Any</option>
                                        <option value="A1">A1</option>
                                        <option value="A2">A2</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="C1">C1</option>
                                        <option value="C2">C2</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Additional
                                    Requirements</label>
                                <textarea name="education_levels[3][additional_requirements]" rows="3"
                                    placeholder="Enter any PhD-specific requirements..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <!-- Section 5: Bond Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Bond Information</h2>
                </div>
                <div class="p-6">
                    <label class="flex items-center gap-3 mb-6">
                        <input type="checkbox" name="bond_required" id="bond_required" onchange="toggleBondFields()"
                            class="rounded border-gray-300 text-[#2C3BEB] focus:ring-[#2C3BEB] h-4 w-4">
                        <span class="text-sm font-semibold text-gray-800">A bond is required for this scholarship</span>
                    </label>

                    <div id="bond_details"
                        class="hidden grid grid-cols-1 md:grid-cols-2 gap-6 pl-7 border-l-2 border-[#2C3BEB] ml-1.5 mt-2 transition-all">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Bond
                                Duration (Years)</label>
                            <input type="number" name="bond_duration"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Bond
                                Organization</label>
                            <input type="text" name="bond_organization" placeholder="e.g., PETRONAS"
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
                    Publish Scholarship
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('create_scholarship_form').addEventListener('submit', function (event) {
            // Warn on duplicate SPM subjects within a block
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
            if (isChecked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
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