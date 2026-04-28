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

        {{-- Unified Scholarship Table --}}
        @if($applications->isEmpty() && $notApplied->isEmpty())
            <div class="bg-white p-10 rounded-2xl border border-gray-200 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Recommendations or Applications</h3>
                <p class="text-gray-500">This student has not yet run the recommendation engine.</p>
            </div>
        @else
            @php
                $allScholarships = $applications->map(function($app) {
                    return (object)[
                        'name' => $app->scholarship_name,
                        'application_status' => 'Applied',
                        'acceptance_status' => $app->acceptance_status,
                        'application' => $app,
                    ];
                })->concat($notApplied->map(function($name) {
                    return (object)[
                        'name' => $name,
                        'application_status' => 'Not Applied',
                        'acceptance_status' => 'Not Applied',
                        'application' => null,
                    ];
                }))->sortBy('name');
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Scholarship</th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Application Status</th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Acceptance Status</th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Update Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($allScholarships as $item)
                            @php
                                $statusColors = [
                                    'Pending'  => 'bg-yellow-100 text-yellow-800',
                                    'Accepted' => 'bg-green-100 text-green-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    'Not Applied' => 'bg-gray-100 text-gray-500',
                                ];
                                $colorClass = $statusColors[$item->acceptance_status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 font-medium {{ $item->application_status === 'Not Applied' ? 'text-gray-400 italic' : 'text-gray-900' }}">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $item->application_status === 'Applied' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $item->application_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                        {{ $item->acceptance_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->application)
                                        <form method="POST"
                                            action="{{ route('admin.applications.updateStatus', $item->application) }}"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="acceptance_status"
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent">
                                                <option value="Pending"  @selected($item->application->acceptance_status === 'Pending')>Pending</option>
                                                <option value="Accepted" @selected($item->application->acceptance_status === 'Accepted')>Accepted</option>
                                                <option value="Rejected" @selected($item->application->acceptance_status === 'Rejected')>Rejected</option>
                                            </select>
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-[#2C3BEB] hover:bg-[#2130d4] text-white text-xs font-semibold rounded-lg transition duration-150">
                                                Update
                                            </button>
                                        </form>
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
