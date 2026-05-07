<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-center text-center mb-8 gap-2">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Student Applications</h1>
            <p class="text-sm text-gray-500 max-w-2xl">Review all scholarship applications submitted by students.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if($applications->isEmpty())
            <div class="bg-white p-10 rounded-2xl border border-gray-200 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Applications Found</h3>
                <p class="text-gray-500">There are currently no student applications to review.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Student Details</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Scholarship</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Application Status</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Proof of Application</th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($applications as $app)
                                @php
                                    $statusColors = [
                                        'Not Apply' => 'bg-gray-100 text-gray-500',
                                        'Applied'   => 'bg-blue-100 text-blue-700',
                                        'Approved'  => 'bg-green-100 text-green-800',
                                        'Rejected'  => 'bg-red-100 text-red-800',
                                    ];
                                    $colorClass = $statusColors[$app->status] ?? 'bg-gray-100 text-gray-500';
                                @endphp
                                <tr class="hover:bg-gray-50 transition duration-100">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $app->user->name }}</div>
                                        <div class="text-gray-500 text-xs">{{ $app->user->email }}</div>
                                        <div class="text-gray-500 text-xs mt-0.5">{{ $app->user->phone_num ?? 'No phone number' }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $app->scholarship_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                            {{ $app->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($app->is_proof_submitted)
                                            @if($app->proof_path)
                                                <a href="{{ $app->proof_url }}" target="_blank" class="text-[#2C3BEB] hover:underline text-xs font-semibold flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                    View Proof
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs italic">N/A</span>
                                            @endif
                                        @elseif(!$app->is_proof_submitted && $app->proof_path)
                                            <div class="flex items-center gap-1.5 text-yellow-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="text-[11px] font-bold uppercase tracking-wider">Not Submitted</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST"
                                            action="{{ route('admin.applications.updateStatus', $app) }}"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            @php
                                                $isSubmittable = $app->is_proof_submitted;
                                            @endphp
                                            <select name="status"
                                                class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#2C3BEB] focus:border-transparent {{ !$isSubmittable ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                                                {{ !$isSubmittable ? 'disabled' : '' }}>
                                                <option value="Not Apply" @selected($app->status === 'Not Apply')>Not Apply</option>
                                                <option value="Applied"   @selected($app->status === 'Applied')>Applied</option>
                                                <option value="Approved"  @selected($app->status === 'Approved')>Approved</option>
                                                <option value="Rejected"  @selected($app->status === 'Rejected')>Rejected</option>
                                            </select>
                                            <button type="submit"
                                                class="px-3 py-1.5 text-white text-xs font-semibold rounded-lg transition duration-150 {{ !$isSubmittable ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#2C3BEB] hover:bg-[#2130d4]' }}"
                                                {{ !$isSubmittable ? 'disabled' : '' }}>
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
