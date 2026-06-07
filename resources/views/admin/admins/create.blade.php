<x-app-layout>
    <div class="max-w-xl mx-auto py-10">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-10">
            <h2 id="signup-title" class="font-bold text-gray-900 mb-1" style="font-size: 2rem;">Create Admin</h2>
            <p class="text-sm text-blue-600 mb-8">Create a new administrator account.</p>

            <form method="POST" action="{{ route('admins.store') }}">
                @csrf

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
                        placeholder="Jane Smith"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email + Phone -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="admin@system.edu"
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
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition"
                        >
                        @error('phone_num')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="mb-4">
                    <label for="role" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Admin Role</label>
                    <select
                        id="role"
                        name="role"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition bg-white"
                        onchange="toggleProviderField()"
                    >
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="representative" {{ old('role') === 'representative' ? 'selected' : '' }}>Scholarship Representative</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Provider Name (Hidden by default, shown for representatives) -->
                <div id="provider_field" class="mb-4 {{ old('role') === 'representative' ? '' : 'hidden' }}">
                    <label for="provider_name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Assigned Provider</label>
                    <div class="space-y-2">
                        <!-- Select Existing Provider -->
                        <select id="existing_provider" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition bg-white" onchange="syncProviderName()">
                            <option value="">-- Select Existing Provider --</option>
                            @foreach($providers as $provider)
                                <option value="{{ $provider }}" {{ old('provider_name') === $provider ? 'selected' : '' }}>{{ $provider }}</option>
                            @endforeach
                            <option value="other">-- Enter New Provider --</option>
                        </select>
                        
                        <!-- Free Text Provider Input -->
                        <input
                            id="provider_name"
                            type="text"
                            name="provider_name"
                            value="{{ old('provider_name') }}"
                            placeholder="e.g. Yayasan Terengganu"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent transition {{ old('provider_name') && !in_array(old('provider_name'), $providers->toArray()) ? '' : 'hidden' }}"
                        >
                    </div>
                    @error('provider_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-8">
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

                <!-- Create Button -->
                <button
                    type="submit"
                    class="w-full bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-semibold text-sm py-3 rounded-lg transition-colors"
                >
                    Create Admin Account
                </button>
                
                <div class="text-center mt-5 text-sm text-gray-500">
                    <a href="{{ route('admins.index') }}" class="hover:underline">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleProviderField() {
            const role = document.getElementById('role').value;
            const providerField = document.getElementById('provider_field');
            if (role === 'representative') {
                providerField.classList.remove('hidden');
            } else {
                providerField.classList.add('hidden');
                document.getElementById('provider_name').value = '';
            }
        }

        function syncProviderName() {
            const select = document.getElementById('existing_provider');
            const input = document.getElementById('provider_name');
            
            if (select.value === 'other') {
                input.classList.remove('hidden');
                input.value = '';
                input.focus();
            } else if (select.value !== '') {
                input.classList.add('hidden');
                input.value = select.value;
            } else {
                input.classList.add('hidden');
                input.value = '';
            }
        }

        // Initialize state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('existing_provider');
            const input = document.getElementById('provider_name');
            if (input.value && select.value === '') {
                // Determine if it matches an existing option
                let matched = false;
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value === input.value) {
                        select.selectedIndex = i;
                        matched = true;
                        break;
                    }
                }
                if (!matched) {
                    select.value = 'other';
                    input.classList.remove('hidden');
                }
            }
        });
    </script>
</x-app-layout>
