<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <p class="text-sm text-gray-500 mt-1">View your account details and information.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                
                <!-- Common Fields -->
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Full Name</label>
                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email Address</label>
                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone Number</label>
                    <p class="text-gray-900 font-medium">{{ $user->phone_num ?? 'Not provided' }}</p>
                </div>

                @if($user->role === 'student')
                    <!-- Student Specific Fields -->
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Gender</label>
                        <p class="text-gray-900 font-medium capitalize">{{ $user->gender ?? 'Not provided' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Marital Status</label>
                        <p class="text-gray-900 font-medium capitalize">{{ $user->marital_status ?? 'Not provided' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nationality</label>
                        <p class="text-gray-900 font-medium">{{ $user->nationality ?? 'Not provided' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Birth State</label>
                        <p class="text-gray-900 font-medium">{{ $user->birth_state ?? 'Not provided' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Date of Birth</label>
                        <p class="text-gray-900 font-medium">{{ $user->dob ?? 'Not provided' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Study Location</label>
                        <p class="text-gray-900 font-medium">{{ $user->study_location ?? 'Not provided' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Place of Study</label>
                        <p class="text-gray-900 font-medium">{{ $user->place_of_study ?? 'Not provided' }}</p>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Residential Address</label>
                        <p class="text-gray-900 font-medium">{{ $user->address ?? 'Not provided' }}</p>
                    </div>
                @endif

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Password</label>
                    <p class="text-gray-900 font-medium">••••••••</p>
                </div>

            </div>

            <!-- Actions -->
            <div class="mt-12 pt-8 border-t border-gray-50 flex justify-between items-center">
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold text-sm px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                        Delete Account
                    </button>
                </form>

                <a href="{{ route('profile.edit') }}" 
                   class="bg-[#2C3BEB] hover:bg-[#2130d4] text-white font-semibold text-sm px-8 py-3 rounded-lg transition-colors flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Update Profile
                </a>
            </div>
        </div>
    </div>
</x-app-layout>