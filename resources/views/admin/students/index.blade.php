<x-app-layout headerTitle="Students">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-10 text-center flex flex-col items-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Students</h1>
            <p class="text-base text-gray-500 mt-2 max-w-2xl">
                Manage student accounts and review their scholarship applications.
            </p>
        </div>

        @if($students->isEmpty())
            <div class="bg-white p-10 rounded-2xl border border-gray-200 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Students Found</h3>
                <p class="text-gray-500">No student accounts have been registered yet.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#7DAACB] bg-[#7DAACB]">
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Name</th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Email</th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Phone Number</th>
                            <th class="text-left text-xs font-semibold text-white uppercase tracking-wider px-6 py-4">Place of Study</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $student)
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $student->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $student->email }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $student->phone_num ?? '—' }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $student->place_of_study ?? '—' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.students.applications', $student) }}"
                                        class="inline-flex items-center px-4 py-2 bg-[#2C3BEB] hover:bg-[#2130d4] text-white text-xs font-semibold rounded-lg transition duration-150">
                                        Application
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
