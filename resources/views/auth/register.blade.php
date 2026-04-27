<x-guest-layout headerTitle="Sign Up">
    <h2 id="signup-title" class="font-bold text-gray-900 mb-1" style="font-size: 2rem;">Create Student</h2>
    <p class="text-sm text-blue-600 mb-6">Join our community of scholars today.</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}" x-data="{ studyLocation: '{{ old('study_location') }}' }">
        @csrf
        <input type="hidden" name="role" value="student">

        <!-- Full Name -->
        <div class="mb-4">
            <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Full Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Johnathan Doe"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
            >
            @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email + Phone -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="john@university.edu"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="phone_num" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Phone Number</label>
                <input
                    id="phone_num"
                    type="tel"
                    name="phone_num"
                    value="{{ old('phone_num') }}"
                    placeholder="+1 (555) 000-0000"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('phone_num')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Residential Address -->
        <div class="mb-4">
            <label for="address" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Residential Address</label>
            <input
                id="address"
                type="text"
                name="address"
                value="{{ old('address') }}"
                placeholder="123 Scholar Way, Academic City"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
            >
            @error('address')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Gender + Marital Status -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label for="gender" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Gender</label>
                <select
                    id="gender"
                    name="gender"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition appearance-none"
                >
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="marital_status" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Marital Status</label>
                <select
                    id="marital_status"
                    name="marital_status"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition appearance-none"
                >
                    <option value="" disabled {{ old('marital_status') ? '' : 'selected' }}>Select Status</option>
                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
                @error('marital_status')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- DOB + Nationality -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label for="dob" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Date of Birth</label>
                <input
                    id="dob"
                    type="date"
                    name="dob"
                    value="{{ old('dob') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('dob')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="nationality" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nationality</label>
                <input
                    id="nationality"
                    type="text"
                    name="nationality"
                    value="{{ old('nationality') }}"
                    placeholder="e.g. United States"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('nationality')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Birth State + Place of Study -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label for="birth_state" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Birth State/Province</label>
                <input
                    id="birth_state"
                    type="text"
                    name="birth_state"
                    value="{{ old('birth_state') }}"
                    placeholder="e.g. California"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('birth_state')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="place_of_study" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Place of Study</label>
                <input
                    id="place_of_study"
                    type="text"
                    name="place_of_study"
                    value="{{ old('place_of_study') }}"
                    placeholder="e.g. Stanford University"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('place_of_study')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Study Location + Study Country -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label for="study_location" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Study Location</label>
                <select
                    id="study_location"
                    name="study_location"
                    x-model="studyLocation"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition appearance-none"
                >
                    <option value="" disabled {{ old('study_location') ? '' : 'selected' }}>Select Location</option>
                    <option value="Local" {{ old('study_location') == 'Local' ? 'selected' : '' }}>Local</option>
                    <option value="Overseas" {{ old('study_location') == 'Overseas' ? 'selected' : '' }}>Overseas</option>
                </select>
                @error('study_location')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div x-show="studyLocation === 'Overseas'" x-cloak>
                <label for="study_country" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Study Country</label>
                <input
                    id="study_country"
                    type="text"
                    name="study_country"
                    value="{{ old('study_country') }}"
                    placeholder="e.g. Egypt, UK"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
                @error('study_country')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Create Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
            >
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Hidden confirm password (same value, no confirmation UI needed) -->
        <input type="hidden" name="password_confirmation" id="password_confirmation">

        <!-- Sign Up Button -->
        <button
            type="submit"
            class="w-full bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-semibold text-sm py-3 rounded-lg transition-colors"
        >
            Sign Up
        </button>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-500 mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#2C3BEB] font-semibold hover:underline">Login</a>
        </p>
    </form>

    <script>
        // Sync password confirmation with password field
        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('password_confirmation').value = this.value;
        });
    </script>
</x-guest-layout>
