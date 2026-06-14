<section x-data="{ studyLocation: '{{ old('study_location', $user->study_location) }}' }">
    <form id="profile-update-form" method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- ── 1. Personal Information ────────────────────────── --}}
        <div class="ep-section">
            <div class="ep-section-header">
                <div class="ep-section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <div class="ep-section-title">Personal Information</div>
                    <div class="ep-section-sub">Your basic personal details.</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Full Name --}}
                <div class="ep-field">
                    <label class="ep-label" for="name">Full Name</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                        <input id="name" name="name" type="text" class="ep-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>

                {{-- Email --}}
                <div class="ep-field">
                    <label class="ep-label" for="email">Email Address</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span>
                        <input id="email" name="email" type="email" class="ep-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('email')" />
                </div>

                {{-- Phone Number --}}
                <div class="ep-field">
                    <label class="ep-label" for="phone_num">Phone Number</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.04z"/></svg></span>
                        <input id="phone_num" name="phone_num" type="tel" class="ep-input" value="{{ old('phone_num', $user->phone_num) }}" autocomplete="tel" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('phone_num')" />
                </div>

                {{-- Gender --}}
                <div class="ep-field">
                    <label class="ep-label" for="gender">Gender</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg></span>
                        <select id="gender" name="gender" class="ep-select">
                            <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>Select Gender</option>
                            <option value="male"   {{ old('gender', $user->gender) == 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender', $user->gender) == 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('gender')" />
                </div>

                {{-- Marital Status --}}
                <div class="ep-field">
                    <label class="ep-label" for="marital_status">Marital Status</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></span>
                        <select id="marital_status" name="marital_status" class="ep-select">
                            <option value="" disabled {{ old('marital_status', $user->marital_status) ? '' : 'selected' }}>Select Status</option>
                            <option value="single"   {{ old('marital_status', $user->marital_status) == 'single'   ? 'selected' : '' }}>Single</option>
                            <option value="married"  {{ old('marital_status', $user->marital_status) == 'married'  ? 'selected' : '' }}>Married</option>
                            <option value="divorced" {{ old('marital_status', $user->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="widowed"  {{ old('marital_status', $user->marital_status) == 'widowed'  ? 'selected' : '' }}>Widowed</option>
                        </select>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('marital_status')" />
                </div>

                {{-- Nationality --}}
                <div class="ep-field">
                    <label class="ep-label" for="nationality">Nationality</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
                        <select id="nationality" name="nationality" class="ep-select">
                            <option value="" disabled {{ old('nationality', $user->nationality) ? '' : 'selected' }}>Select Nationality</option>
                            <option value="Malaysian"     {{ old('nationality', $user->nationality) == 'Malaysian'     ? 'selected' : '' }}>Malaysian</option>
                            <option value="Non-Malaysian" {{ old('nationality', $user->nationality) == 'Non-Malaysian' ? 'selected' : '' }}>Non-Malaysian</option>
                        </select>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('nationality')" />
                </div>

                {{-- Birth State --}}
                <div class="ep-field">
                    <label class="ep-label" for="birth_state">Birth State / Province</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg></span>
                        <input id="birth_state" name="birth_state" type="text" class="ep-input" value="{{ old('birth_state', $user->birth_state) }}" placeholder="e.g. Selangor">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('birth_state')" />
                </div>

                {{-- Date of Birth --}}
                <div class="ep-field">
                    <label class="ep-label" for="dob">Date of Birth</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                        <input id="dob" name="dob" type="date" class="ep-input" value="{{ old('dob', $user->dob) }}">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('dob')" />
                </div>

            </div>
        </div>

        {{-- ── 2. Address Information ──────────────────────────── --}}
        <div class="ep-section">
            <div class="ep-section-header">
                <div class="ep-section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div>
                    <div class="ep-section-title">Address Information</div>
                    <div class="ep-section-sub">Your residential address details.</div>
                </div>
            </div>

            <div class="ep-field">
                <label class="ep-label" for="address">Residential Address</label>
                <div class="ep-input-wrap">
                    <span class="ep-textarea-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                    <textarea id="address" name="address" class="ep-textarea" rows="3" placeholder="Enter your full residential address">{{ old('address', $user->address) }}</textarea>
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('address')" />
            </div>
        </div>

        {{-- ── 3. Academic Information ─────────────────────────── --}}
        <div class="ep-section">
            <div class="ep-section-header">
                <div class="ep-section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3.5 2 8.5 2 12 0v-5"/></svg>
                </div>
                <div>
                    <div class="ep-section-title">Academic Information</div>
                    <div class="ep-section-sub">Your academic and institution details.</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Study Location --}}
                <div class="ep-field">
                    <label class="ep-label" for="study_location">Study Location</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                        <select id="study_location" name="study_location" x-model="studyLocation" class="ep-select">
                            <option value="" disabled {{ old('study_location', $user->study_location) ? '' : 'selected' }}>Select Location</option>
                            <option value="Local"    {{ old('study_location', $user->study_location) == 'Local'    ? 'selected' : '' }}>Local</option>
                            <option value="Overseas" {{ old('study_location', $user->study_location) == 'Overseas' ? 'selected' : '' }}>Overseas</option>
                        </select>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('study_location')" />
                </div>

                {{-- Institution Name --}}
                <div class="ep-field" x-show="studyLocation" x-cloak>
                    <label class="ep-label" for="place_of_study">Institution Name</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/></svg></span>
                        <input id="place_of_study" name="place_of_study" type="text" class="ep-input" value="{{ old('place_of_study', $user->place_of_study) }}" placeholder="e.g. Universiti Malaya">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('place_of_study')" />
                </div>

                {{-- Study Country (Overseas only) --}}
                <div class="ep-field" x-show="studyLocation === 'Overseas'" x-cloak>
                    <label class="ep-label" for="study_country">Study Country</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
                        <input id="study_country" name="study_country" type="text" class="ep-input" value="{{ old('study_country', $user->study_country) }}" placeholder="e.g. Egypt, UK">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('study_country')" />
                </div>

                {{-- Top 100 Checkbox --}}
                <div class="ep-checkbox-row md:col-span-2" x-show="studyLocation" x-cloak>
                    <input id="is_top_100_university" type="checkbox" name="is_top_100_university" value="1"
                        {{ old('is_top_100_university', $user->is_top_100_university) ? 'checked' : '' }}>
                    <label for="is_top_100_university">My institution is ranked in the Global Top 100</label>
                </div>

            </div>
        </div>

        {{-- ── 3. Security Settings ────────────────────────────── --}}
        <div class="ep-section">
            <div class="ep-section-header">
                <div class="ep-section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div>
                    <div class="ep-section-title">Security Settings</div>
                    <div class="ep-section-sub">Update your password to keep your account secure.</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="ep-field">
                    <label class="ep-label" for="password">New Password</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                        <input id="password" name="password" type="password" class="ep-input" placeholder="Leave blank to keep current" autocomplete="new-password">
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('password')" />
                </div>
            </div>
        </div>
    </form>{{-- /profile-update-form --}}

        {{-- ── Action Buttons ──────────────────────────────────── --}}
        <div class="ep-actions">
            <button type="button" onclick="openDeleteModal('{{ route('profile.destroy') }}', 'Delete Your Account?', 'This action is permanent and cannot be undone.<br>Please read carefully before proceeding.')" class="ep-btn-delete">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                Delete Account
            </button>

            <div class="flex items-center gap-4">
                @if(session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-semibold">Saved!</p>
                @endif
                <button type="submit" form="profile-update-form" class="ep-btn-save">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
            </div>
        </div>
</section>

@include('profile.partials.delete-account-modal')