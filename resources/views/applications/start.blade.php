<x-app-layout headerTitle="Start Application">
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Banner -->
        <div class="relative w-full rounded-3xl overflow-hidden flex items-center mb-8 shadow-md h-[140px] md:h-[180px] mt-2"
             style="background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat, linear-gradient(to right, #C8D5F8, #BDD0FF);">
            <div class="absolute inset-0 bg-gradient-to-r from-[#C8D5F8]/95 via-[#C8D5F8]/60 to-transparent pointer-events-none"></div>
            <div class="relative z-10 px-8 md:px-12 max-w-2xl">
                <div class="flex items-center gap-4 mb-3">
                    <div class="p-2.5 bg-white rounded-xl shadow-sm text-[#2C3BEB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#0B1221] tracking-tight leading-tight">Offline Scholarships Application</h1>
                </div>
                <p class="text-sm text-gray-800 leading-relaxed font-semibold">These scholarships match your profile. Click <strong>Update</strong> to prepare your offline application form and download the PDF for manual submission.</p>
            </div>
        </div>

        @if(session('errors'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-700">
                {{ session('errors')->first('msg') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
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
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recommendations as $rec)
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $rec['name'] }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $rec['provider'] }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('applications.offline-form', ['scholarship' => $rec['name']]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-[#2C3BEB] text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-[#2130d4] hover:shadow-lg transition-all active:scale-95">
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