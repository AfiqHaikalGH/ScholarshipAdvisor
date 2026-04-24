<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
                <p class="text-sm text-gray-500 mt-1">Update your personal information and account settings.</p>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
            <!-- ADMIN FORM -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', auth()->user()->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', auth()->user()->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="phone_num" :value="__('Phone Number')" />
                            <x-text-input id="phone_num" name="phone_num" type="text" class="mt-1 block w-full" :value="old('phone_num', auth()->user()->phone_num)" autocomplete="tel" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone_num')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('New Password (leave blank to keep current)')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                        <x-primary-button class="bg-[#2C3BEB] hover:bg-[#2130d4]">{{ __('Save Changes') }}</x-primary-button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        @else
            <!-- STUDENT FORM -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                @include('profile.partials.update-profile-information-form')
            </div>
        @endif
    </div>
</x-app-layout>
