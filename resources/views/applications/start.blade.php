<x-app-layout headerTitle="Start Application">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Offline Scholarships
                Application</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">
                These scholarships match your profile. Click <strong>Update</strong> to prepare your offline application
                form and download the PDF for manual submission.
            </p>
        </div>

        @if(session('errors'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-700">
                {{ session('errors')->first('msg') }}
            </div>
        @endif

        <div class="bg-white shadow-xl border border-gray-200 rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Scholarship Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Provider</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($recommendations as $rec)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $rec['name'] }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">{{ $rec['provider'] }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <a href="{{ route('applications.offline-form', ['scholarship' => $rec['name']]) }}"
                                        class="inline-flex items-center px-5 py-2.5 bg-[#2C3BEB] text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#2130d4] hover:shadow-lg transition-all active:scale-95">
                                        Update
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">No Recommendations of Offline
                                            Scholarship</h3>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>