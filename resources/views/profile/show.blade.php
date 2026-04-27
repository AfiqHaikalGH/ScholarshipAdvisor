<x-app-layout headerTitle="My Profile">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">My Profile</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">View your account details and personal information.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-3">
                
                <!-- Full Name -->
                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Full Name</label>
                    <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->name }}</p>
                </div>

                <!-- Email Address -->
                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Email Address</label>
                    <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->email }}</p>
                </div>

                <!-- Phone Number -->
                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Phone Number</label>
                    <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->phone_num ?? 'Not provided' }}</p>
                </div>

                <!-- Password -->
                <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Password</label>
                    <p class="text-sm font-medium text-gray-900 leading-tight">••••••••</p>
                </div>

                @if($user->role === 'student')
                    <!-- Gender -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Gender</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight capitalize">{{ $user->gender ?? 'Not provided' }}</p>
                    </div>

                    <!-- Marital Status -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Marital Status</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight capitalize">{{ $user->marital_status ?? 'Not provided' }}</p>
                    </div>

                    <!-- Nationality -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Nationality</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->nationality ?? 'Not provided' }}</p>
                    </div>

                    <!-- Birth State -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Birth State</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->birth_state ?? 'Not provided' }}</p>
                    </div>

                    <!-- Date of Birth -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Date of Birth</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->dob ?? 'Not provided' }}</p>
                    </div>

                    <!-- Study Location -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Study Location</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->study_location ?? 'Not provided' }}</p>
                    </div>

                    <!-- Place of Study -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Place of Study</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->place_of_study ?? 'Not provided' }}</p>
                    </div>

                    <!-- Address -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 flex flex-col items-center text-center transition-all hover:shadow-sm">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Residential Address</label>
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ $user->address ?? 'Not provided' }}</p>
                    </div>
                @endif

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