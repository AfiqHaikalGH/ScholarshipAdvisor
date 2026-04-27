<x-app-layout headerTitle="Applications">
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Applications</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">
                All scholarships you are eligible for (100% match) and their application status.
            </p>
        </div>

        @if($scholarships->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white p-10 rounded-2xl border border-gray-200 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#2C3BEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Eligible Scholarships Yet</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                    You have no scholarships with a 100% match score. Fill in your qualifications to get recommendations.
                </p>
                <a href="{{ route('qualifications.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-[#2C3BEB] text-white text-sm font-semibold rounded-lg hover:bg-[#2130d4] transition duration-150">
                    Go to Qualifications
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">
                                Scholarship Name
                            </th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">
                                Deadline
                            </th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">
                                Action
                            </th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($scholarships as $scholarship)
                            @php
                                $statusColors = [
                                    'Pending'  => 'bg-yellow-100 text-yellow-800',
                                    'Accepted' => 'bg-green-100 text-green-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                ];
                                $statusClass = $statusColors[$scholarship['acceptance_status'] ?? ''] ?? 'bg-gray-100 text-gray-500';
                            @endphp
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $scholarship['scholarship_name'] }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $scholarship['deadline'] ? \Carbon\Carbon::parse($scholarship['deadline'])->format('d M Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($scholarship['applied'])
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Applied
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                            Not Applied
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($scholarship['acceptance_status'])
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ $scholarship['acceptance_status'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
