<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Back link + Header --}}
        <div class="mb-8">
            <a href="{{ route('admin.students.index') }}"
                class="inline-flex items-center text-sm text-[#2C3BEB] hover:underline mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Students
            </a>

            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}'s Applications</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
        </div>

        {{-- Success message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Applied Scholarships --}}
        @if($applications->isEmpty() && $notApplied->isEmpty())
            <div class="bg-white p-10 rounded-2xl border border-gray-200 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Recommendations or Applications</h3>
                <p class="text-gray-500">This student has not yet run the recommendation engine.</p>
            </div>
        @else
            @if($applications->isNotEmpty())
                <h2 class="text-base font-semibold text-gray-700 mb-3">Applied Scholarships</h2>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Scholarship</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Applied On</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Status</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($applications as $application)
                                @php
                                    $statusColors = [
                                        'Pending'  => 'bg-yellow-100 text-yellow-800',
                                        'Accepted' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $colorClass = $statusColors[$application->acceptance_status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <tr class="hover:bg-gray-50 transition duration-100">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $application->scholarship_name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $application->applied_at?->format('d M Y') ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                            {{ $application->acceptance_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST"
                                            action="{{ route('admin.applications.updateStatus', $application) }}"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="acceptance_status"
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent">
                                                <option value="Pending"  @selected($application->acceptance_status === 'Pending')>Pending</option>
                                                <option value="Accepted" @selected($application->acceptance_status === 'Accepted')>Accepted</option>
                                                <option value="Rejected" @selected($application->acceptance_status === 'Rejected')>Rejected</option>
                                            </select>
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-[#2C3BEB] hover:bg-[#2130d4] text-white text-xs font-semibold rounded-lg transition duration-150">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Recommended but not applied --}}
            @if($notApplied->isNotEmpty())
                <h2 class="text-base font-semibold text-gray-700 mb-3">Recommended — Not Applied</h2>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Scholarship</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($notApplied as $name)
                                <tr class="hover:bg-gray-50 transition duration-100">
                                    <td class="px-6 py-4 text-gray-400 italic">{{ $name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                            Not Applied
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
