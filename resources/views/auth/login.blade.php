<x-guest-layout headerTitle="Log In">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Log In</h2>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Role Selector -->
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Login as:</p>
        <div class="grid grid-cols-2 gap-3 mb-6" id="role-selector">
            <button
                id="role-student-btn"
                type="button"
                onclick="selectLoginRole('student')"
                class="role-btn flex flex-col items-center gap-1 py-3 px-4 rounded-lg border-2 border-gray-200 bg-white text-gray-500 font-medium text-sm transition-all"
            >
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="text-gray-500">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
                Student
            </button>
            <button
                id="role-admin-btn"
                type="button"
                onclick="selectLoginRole('admin')"
                class="role-btn flex flex-col items-center gap-1 py-3 px-4 rounded-lg border-2 border-[#2C3BEB] bg-white text-gray-700 font-medium text-sm transition-all"
            >
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="text-gray-700">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-1 14l-3-3 1.41-1.41L11 12.17l4.59-4.58L17 9l-6 6z"/>
                </svg>
                Admin
            </button>
        </div>
        <input type="hidden" name="role" id="login-role-input" value="admin">

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your email"
                    class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
            </div>
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-[#2C3BEB] hover:underline font-medium">Forgot password?</a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                >
            </div>
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Log In Button -->
        <button
            type="submit"
            class="w-full bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-semibold text-sm py-3 rounded-lg transition-colors"
        >
            Log In
        </button>

        <!-- Sign Up Link -->
        <p class="text-center text-sm text-gray-500 mt-4">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-[#2C3BEB] font-bold hover:underline">Sign Up</a>
        </p>
    </form>

    <script>
        function selectLoginRole(role) {
            document.getElementById('login-role-input').value = role;
            const adminBtn   = document.getElementById('role-admin-btn');
            const studentBtn = document.getElementById('role-student-btn');

            if (role === 'admin') {
                // Activate admin button
                adminBtn.classList.remove('border-gray-200', 'text-gray-500');
                adminBtn.classList.add('border-[#2C3BEB]', 'text-gray-700');
                adminBtn.querySelector('svg').classList.remove('text-gray-500');
                adminBtn.querySelector('svg').classList.add('text-gray-700');

                // Deactivate student button
                studentBtn.classList.remove('border-[#2C3BEB]', 'text-gray-700');
                studentBtn.classList.add('border-gray-200', 'text-gray-500');
                studentBtn.querySelector('svg').classList.remove('text-gray-700');
                studentBtn.querySelector('svg').classList.add('text-gray-500');
            } else {
                // Activate student button
                studentBtn.classList.remove('border-gray-200', 'text-gray-500');
                studentBtn.classList.add('border-[#2C3BEB]', 'text-gray-700');
                studentBtn.querySelector('svg').classList.remove('text-gray-500');
                studentBtn.querySelector('svg').classList.add('text-gray-700');

                // Deactivate admin button
                adminBtn.classList.remove('border-[#2C3BEB]', 'text-gray-700');
                adminBtn.classList.add('border-gray-200', 'text-gray-500');
                adminBtn.querySelector('svg').classList.remove('text-gray-700');
                adminBtn.querySelector('svg').classList.add('text-gray-500');
            }
        }

        // Set default role or restore from old input
        selectLoginRole('{{ old('role', 'admin') }}');
    </script>

</x-guest-layout>
