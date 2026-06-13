<x-app-layout headerTitle="Students">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Section -->
        <div class="relative w-full rounded-3xl overflow-hidden flex items-center mb-8 shadow-md h-[140px] md:h-[180px]"
             style="background: url('{{ asset('images/hero_banner.png') }}') center/cover no-repeat, linear-gradient(to right, #C8D5F8, #BDD0FF);">

            <!-- Left overlay gradient so text is readable -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#C8D5F8]/95 via-[#C8D5F8]/60 to-transparent pointer-events-none"></div>

            <!-- Text Content -->
            <div class="relative z-10 px-6 md:px-10 max-w-xs md:max-w-md">
                <h1 class="text-lg md:text-2xl font-extrabold text-[#0B1221] tracking-tight leading-tight mb-1">
                    Student Accounts &amp; <br />
                    <span class="text-[#1E2DB8]">Applications</span>
                </h1>
                <p class="text-[10px] md:text-xs text-gray-700 leading-snug font-medium mt-1">
                    Manage student accounts and review<br class="hidden md:block"> their scholarship applications.
                </p>
            </div>
        </div>

        @if($students->isEmpty())
            <div class="bg-white p-10 rounded-2xl border border-gray-200 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Students Found</h3>
                <p class="text-gray-500">No student accounts have been registered yet.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
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
            </div>
        @endif
    </div>
</x-app-layout>
