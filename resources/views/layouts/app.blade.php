<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($headerTitle) {{ $headerTitle }} | @endisset {{ config('app.name', 'ScholarshipAdvisor') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }

            /* Sticky Nav adjustment */
            nav {
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }



            /* Dropdown animation */
            .user-dropdown {
                display: none;
                position: absolute;
                right: 0;
                top: calc(100% + 8px);
                min-width: 180px;
                background: white;
                border: 1px solid #E5E7EB;
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.10);
                z-index: 50;
                overflow: hidden;
            }
            .user-dropdown.open {
                display: block;
            }
            .user-dropdown a,
            .user-dropdown button {
                display: flex;
                align-items: center;
                gap: 8px;
                width: 100%;
                padding: 10px 16px;
                font-size: 14px;
                color: #374151;
                background: none;
                border: none;
                cursor: pointer;
                text-align: left;
                text-decoration: none;
                transition: background 0.15s;
            }
            .user-dropdown a:hover,
            .user-dropdown button:hover {
                background: #EFF6FF; /* Soft light blue */
                color: #2C3BEB; /* Brand blue text on hover */
            }
            /* Role-based backgrounds */
            .bg-student {
                background: #F0F2F5;
            }
            .bg-admin {
                background: radial-gradient(circle at center, #CBDCEB 0%, #608BC1 100%) fixed;
            }

            /* Loose text readability adjustments */
            .bg-student h1:not(.bg-white h1), 
            .bg-student h2:not(.bg-white h2) {
                color: #000000 !important;
            }
            .bg-student p:not(.bg-white p) {
                color: #374151 !important; /* Keeping paragraphs slightly softer gray for better readability */
            }
            
            .bg-admin h1:not(.bg-white h1), 
            .bg-admin h2:not(.bg-white h2) {
                color: #000000 !important;
            }
            .bg-admin p:not(.bg-white p) {
                color: #374151 !important;
            }
        </style>
    </head>
    <body class="antialiased min-h-screen {{ Auth::user() && Auth::user()->role === 'admin' ? 'bg-admin' : 'bg-student' }}">

        <!-- Navigation Bar -->
        <nav class="bg-white/80 backdrop-blur-md border border-gray-200 sticky top-4 z-50 mx-4 md:mx-10 rounded-2xl shadow-md transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Left: Logo + Nav Links -->
                    <div class="flex items-center gap-10">
                        <!-- Logo -->
                        <a href="{{ route('scholarship.info') }}" class="flex items-center gap-2">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="ScholarshipAdvisor Logo" class="h-16 w-auto object-contain" />
                            <span class="font-bold text-gray-900 text-base">ScholarshipAdvisor</span>
                        </a>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex items-center gap-6">
                            <a href="{{ route('scholarship.info') }}"
                               class="text-sm font-medium {{ request()->routeIs('scholarship.info') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                Scholarship Information
                            </a>

                            @if(Auth::check() && Auth::user()->role !== 'admin')
                                <a href="{{ route('qualifications.index') }}"
                                   class="text-sm font-medium {{ request()->routeIs('qualifications.index') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                    Qualifications
                                </a>
                                <a href="{{ route('qualifications.recommendations') }}"
                                   class="text-sm font-medium {{ request()->routeIs('qualifications.recommendations') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                    Recommendations
                                </a>
                                <a href="{{ route('applications.index') }}"
                                   class="text-sm font-medium {{ request()->routeIs('applications.index') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                    Application
                                </a>
                            @endif

                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin.create') }}"
                                   class="text-sm font-medium {{ request()->routeIs('admin.create') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                    Create Admin
                                </a>
                                <a href="{{ route('scholarships.create') }}"
                                   class="text-sm font-medium {{ request()->routeIs('scholarships.create') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                    Create Scholarship
                                </a>
                                <a href="{{ route('admin.students.index') }}"
                                   class="text-sm font-medium {{ request()->routeIs('admin.students.*') ? 'text-[#2C3BEB] border-b-2 border-[#2C3BEB] pb-0.5' : 'text-gray-600 hover:text-gray-900' }} transition-colors">
                                    Students
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Right: User Dropdown -->
                    <div class="relative" id="user-menu-wrapper">
                        <button
                            id="user-menu-trigger"
                            onclick="toggleUserMenu()"
                            class="flex flex-col items-center justify-center px-4 py-1.5 bg-white border border-blue-200 rounded-xl hover:bg-blue-50 transition-all cursor-pointer shadow-sm group"
                        >
                            <span class="text-sm font-medium text-gray-900 group-hover:text-[#2C3BEB] leading-tight transition-colors">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest transition-colors">{{ Auth::user()->role === 'admin' ? 'Admin' : 'Student' }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="user-dropdown" id="user-dropdown">
                            <a href="{{ route('profile.show') }}"> <!-- Updated to profile.show -->
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                My Profile
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </nav>


        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-6 py-10">
            {{ $slot }}
        </main>

        <!-- Close dropdown when clicking outside -->
        <script>
            function toggleUserMenu() {
                const dropdown = document.getElementById('user-dropdown');
                dropdown.classList.toggle('open');
            }

            document.addEventListener('click', function(event) {
                const wrapper = document.getElementById('user-menu-wrapper');
                if (wrapper && !wrapper.contains(event.target)) {
                    document.getElementById('user-dropdown').classList.remove('open');
                }
            });
        </script>
    </body>
</html>
