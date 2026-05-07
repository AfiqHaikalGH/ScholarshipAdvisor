<x-app-layout headerTitle="Applications">
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Scholarship Application Status
            </h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">
                All scholarships you are eligible for (100% match) and their application status.
            </p>
        </div>
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->has('proof'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-semibold">{{ $errors->first('proof') }}</span>
            </div>
        @endif

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
                <div class="overflow-x-auto">
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
                                    Application Status
                                </th>
                                <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">
                                    Proof of Application
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($scholarships as $scholarship)
                                @php
                                    $status = $scholarship['status'] ?? 'Not Apply';
                                    $statusColors = [
                                        'Not Apply' => 'bg-gray-100 text-gray-500',
                                        'Applied' => 'bg-blue-100 text-blue-700',
                                        'Approved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-500';
                                @endphp
                                <tr class="hover:bg-gray-50 transition duration-100">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $scholarship['scholarship_name'] }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $scholarship['deadline'] ? \Carbon\Carbon::parse($scholarship['deadline'])->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($scholarship['is_offline'])
                                            <span class="text-gray-500 text-xs font-semibold italic">Not required</span>
                                        @elseif($scholarship['applied'] && !$scholarship['proof_path'] && $scholarship['id'])
                                            <form action="{{ route('applications.upload-proof', $scholarship['id']) }}"
                                                method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                                @csrf
                                                <input type="file" name="proof"
                                                    class="text-xs file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer w-48"
                                                    required>
                                                <button type="submit"
                                                    class="px-3 py-1 bg-gray-600 text-white text-xs font-semibold rounded-lg hover:bg-gray-700 transition duration-150">
                                                    Save Attachment
                                                </button>
                                            </form>
                                            @error('proof')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        @elseif($scholarship['proof_path'] && !$scholarship['is_proof_submitted'])
                                            <div class="flex items-center gap-3">
                                                <a href="{{ $scholarship['proof_url'] }}" target="_blank"
                                                    class="text-gray-600 hover:text-gray-900 text-xs font-semibold hover:underline"
                                                    title="View Attachment">
                                                    View Attachment
                                                </a>
                                                <form action="{{ route('applications.delete-proof', $scholarship['id']) }}"
                                                    method="POST" class="m-0 p-0"
                                                    onsubmit="return confirm('Are you sure you want to delete this attachment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none"
                                                        title="Delete Attachment">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('applications.submit-proof', $scholarship['id']) }}"
                                                    method="POST" class="m-0 p-0">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-[#2C3BEB] text-white text-xs font-semibold rounded-lg hover:bg-[#2130d4] transition duration-150 ml-2">
                                                        Submit Proof
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($scholarship['proof_path'] && $scholarship['is_proof_submitted'])
                                            <div class="flex items-center gap-2">
                                                <a href="{{ $scholarship['proof_url'] }}" target="_blank"
                                                    class="text-[#2C3BEB] hover:underline text-xs font-semibold" title="View Proof">
                                                    View Attachment
                                                </a>
                                                <span class="text-green-600 text-xs font-semibold flex items-center gap-1 ml-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Submitted
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Click the Apply Now on Recommendations
                                                first</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>