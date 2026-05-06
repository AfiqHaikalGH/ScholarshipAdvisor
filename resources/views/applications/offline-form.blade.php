<x-app-layout headerTitle="Application Form">
    <div class="max-w-4xl mx-auto pb-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Offline Application Form</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">Review your details and generate a PDF to submit manually for <strong>{{ $scholarshipName }}</strong>.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 flex items-center shadow-sm rounded-r-lg">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-indigo-50 border-b border-indigo-100 px-6 py-4">
                <h2 class="text-lg font-bold text-indigo-900">Personal Information</h2>
            </div>
            
            <form id="offline-form" action="{{ route('applications.generate-pdf') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="scholarship_name" value="{{ $scholarshipName }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ... existing fields ... -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->name) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Phone Number</label>
                        <input type="text" name="phone_num" value="{{ old('phone_num', $user->phone_num) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">IC Number</label>
                        <input type="text" name="ic_number" value="{{ old('ic_number', $user->ic_number) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>

                    <div class="col-span-full">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Address</label>
                        <textarea name="address" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Birth State</label>
                        <input type="text" name="birth_state" value="{{ old('birth_state', $user->birth_state) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nationality</label>
                        <input type="text" name="nationality" value="{{ old('nationality', $user->nationality) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB]">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Gender</label>
                        <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#2C3BEB] focus:border-[#2C3BEB] bg-white">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 mb-4 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Qualifications (Read Only)</h3>
                    <div class="space-y-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        @if($qualification)
                            <!-- 1. Academic Summary -->
                            <div>
                                <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-4">Academic Summary</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                                    <div>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase">Education Level</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $qualification->education_level ?: 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase">Field of Study</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $qualification->field_of_study ?: 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase">Enrollment</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ ucfirst($qualification->enrollment_status ?: 'N/A') }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase">Income Category</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $qualification->income_category ?: 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Recorded CGPAs -->
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-4">CGPA Records</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                    @foreach(['Diploma' => 'diploma_cgpa', 'STPM' => 'stpm_cgpa', 'Foundation' => 'foundation_cgpa', 'Bachelor' => 'bachelor_cgpa', 'Master' => 'master_cgpa'] as $label => $field)
                                        @if($qualification->$field)
                                            <div class="bg-white p-2 rounded border border-gray-100">
                                                <span class="block text-[10px] font-bold text-gray-400 uppercase">{{ $label }}</span>
                                                <span class="text-sm font-bold text-indigo-700">{{ number_format($qualification->$field, 2) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- 3. Language & Proficiency -->
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-4">Language & Proficiency</h4>
                                <div class="flex flex-wrap gap-6">
                                    <div>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase">MUET Band</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $qualification->muet_band ?: 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase">CEFR Level</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $qualification->cefr ?: 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Examination Results -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-200 pt-4">
                                <!-- SPM -->
                                <div>
                                    <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-3">SPM Results</h4>
                                    @if($qualification->spm_results && count($qualification->spm_results) > 0)
                                        <div class="space-y-1">
                                            @foreach($qualification->spm_results as $subject => $grade)
                                                <div class="flex justify-between text-sm py-1 border-b border-gray-100">
                                                    <span class="text-gray-600">{{ $subject }}</span>
                                                    <span class="font-bold text-gray-900">{{ $grade }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No SPM results recorded</span>
                                    @endif
                                </div>

                                <!-- STPM -->
                                <div>
                                    <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-3">STPM Results</h4>
                                    @if($qualification->stpm_results && count($qualification->stpm_results) > 0)
                                        <div class="space-y-1">
                                            @foreach($qualification->stpm_results as $subject => $grade)
                                                <div class="flex justify-between text-sm py-1 border-b border-gray-100">
                                                    <span class="text-gray-600">{{ $subject }}</span>
                                                    <span class="font-bold text-gray-900">{{ $grade }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No STPM results recorded</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4 text-gray-400 italic">No qualifications recorded.</div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <button type="submit" formaction="{{ route('applications.save-profile') }}" 
                            class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-gray-50 transition duration-150 shadow-sm active:scale-95">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Save
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-[#2C3BEB] text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#2130d4] hover:shadow-lg transition duration-150 active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                        </svg>
                        Generate PDF
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 rounded-lg text-sm text-blue-800 flex items-start">
            <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p><strong>Note:</strong> Generating the PDF will automatically update your personal profile with any changes made above. You must manually submit the generated PDF to the scholarship provider as instructed by their terms. Generating the PDF does NOT mark your application as 'Applied'. You will need to upload proof of application to mark it as applied.</p>
        </div>
    </div>
</x-app-layout>
