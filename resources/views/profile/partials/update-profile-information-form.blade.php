<section x-data="{ studyLocation: '{{ old('study_location', $user->study_location) }}' }">
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_num" :value="__('Phone Number')" />
                <x-text-input id="phone_num" name="phone_num" type="text" class="mt-1 block w-full" :value="old('phone_num', $user->phone_num)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_num')" />
            </div>

            <!-- Gender -->
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition">
                    <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>Select Gender</option>
                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            <!-- Marital Status -->
            <div>
                <x-input-label for="marital_status" :value="__('Marital Status')" />
                <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition">
                    <option value="" disabled {{ old('marital_status', $user->marital_status) ? '' : 'selected' }}>Select Status</option>
                    <option value="single" {{ old('marital_status', $user->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                    <option value="married" {{ old('marital_status', $user->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                    <option value="divorced" {{ old('marital_status', $user->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                    <option value="widowed" {{ old('marital_status', $user->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
            </div>

            <!-- Nationality -->
            <div>
                <x-input-label for="nationality" :value="__('Nationality')" />
                <x-text-input id="nationality" name="nationality" type="text" class="mt-1 block w-full" :value="old('nationality', $user->nationality)" placeholder="e.g. United States" />
                <x-input-error class="mt-2" :messages="$errors->get('nationality')" />
            </div>

            <!-- Birth State -->
            <div>
                <x-input-label for="birth_state" :value="__('Birth State/Province')" />
                <x-text-input id="birth_state" name="birth_state" type="text" class="mt-1 block w-full" :value="old('birth_state', $user->birth_state)" placeholder="e.g. California" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_state')" />
            </div>

            <!-- Date of Birth -->
            <div>
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $user->dob)" />
                <x-input-error class="mt-2" :messages="$errors->get('dob')" />
            </div>

            <!-- Study Location -->
            <div>
                <x-input-label for="study_location" :value="__('Study Location')" />
                <select id="study_location" name="study_location" x-model="studyLocation" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition">
                    <option value="" disabled {{ old('study_location', $user->study_location) ? '' : 'selected' }}>Select Location</option>
                    <option value="Local" {{ old('study_location', $user->study_location) == 'Local' ? 'selected' : '' }}>Local</option>
                    <option value="Overseas" {{ old('study_location', $user->study_location) == 'Overseas' ? 'selected' : '' }}>Overseas</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('study_location')" />
            </div>

            <!-- Study Country -->
            <div x-show="studyLocation === 'Overseas'" x-cloak>
                <x-input-label for="study_country" :value="__('Study Country')" />
                <x-text-input id="study_country" name="study_country" type="text" class="mt-1 block w-full" :value="old('study_country', $user->study_country)" placeholder="e.g. Egypt, UK" />
                <x-input-error class="mt-2" :messages="$errors->get('study_country')" />
            </div>

            <!-- Place of Study -->
            <div x-show="studyLocation" x-cloak>
                <x-input-label for="place_of_study" :value="__('Institution Name')" />
                <x-text-input id="place_of_study" name="place_of_study" type="text" class="mt-1 block w-full" :value="old('place_of_study', $user->place_of_study)" placeholder="e.g. Universiti Malaya" />
                <x-input-error class="mt-2" :messages="$errors->get('place_of_study')" />
            </div>

            <!-- Top 100 University Checkbox -->
            <div x-show="studyLocation" class="md:col-span-2 flex items-center pt-2" x-cloak>
                <input id="is_top_100_university" type="checkbox" name="is_top_100_university" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_top_100_university', $user->is_top_100_university) ? 'checked' : '' }}>
                <label for="is_top_100_university" class="ml-2 block text-sm text-gray-900 font-medium">
                    My institution is ranked in the Global Top 100
                </label>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('New Password (leave blank to keep current)')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <x-input-label for="address" :value="__('Residential Address')" />
                <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition" rows="3">{{ old('address', $user->address) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-50">
            <x-primary-button class="!bg-[#2C3BEB] hover:!bg-[#2130d4]">{{ __('Save Changes') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>