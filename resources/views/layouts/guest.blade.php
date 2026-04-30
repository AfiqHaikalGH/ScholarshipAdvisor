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
        </style>
    </head>
    <body class="antialiased bg-[#F0F2F5]">

        <!-- Top Navigation Bar -->
        <header class="bg-white/80 backdrop-blur-md border border-gray-200 sticky top-4 z-50 mx-4 md:mx-10 rounded-2xl shadow-md transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-center justify-between h-auto py-3 md:py-0 md:h-16 gap-4">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="ScholarshipAdvisor Logo" class="h-12 md:h-16 w-auto object-contain" />
                        <span class="font-bold text-gray-900 text-base hidden sm:inline">ScholarshipAdvisor</span>
                    </a>

                    <!-- Nav Links -->
                    <nav class="flex items-center gap-4 sm:gap-6 w-full md:w-auto justify-end">
                        <!-- Removed Resources -->
                        <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">About Us</a>
                        @if (request()->routeIs('login'))
                            <a href="{{ route('register') }}" class="text-sm font-medium border border-gray-900 text-gray-900 px-4 py-1.5 rounded-md hover:bg-gray-900 hover:text-white transition-colors">Sign Up</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium border border-gray-900 text-gray-900 px-4 py-1.5 rounded-md hover:bg-gray-900 hover:text-white transition-colors">Login</a>
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-[calc(100vh-57px-48px)] flex items-center justify-center px-4 sm:px-6 py-10">
            <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center lg:items-start gap-8 lg:gap-12">

                <!-- Left Hero Panel -->
                <div class="flex-1 max-w-md">
                    <div class="inline-flex items-center gap-2 bg-white border border-blue-200 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                        VERIFIED SCHOLARSHIPS ONLY
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-black text-gray-900 leading-tight mb-1">
                        Scholarship
                    </h1>
                    <h1 class="text-4xl lg:text-5xl font-black text-[#2C3BEB] leading-tight mb-6">
                        Advisor
                    </h1>

                    <p class="text-gray-500 text-base leading-relaxed mb-8">
                        Centralized scholarship information and personalized recommendations to help you fund your academic journey.
                    </p>

                    <div class="space-y-4">
                        @if (request()->routeIs('login'))
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                </div>
                                <span class="text-sm text-gray-700">Discover 10,000+ active grants</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </div>
                                <span class="text-sm text-gray-700">AI-powered eligibility matching</span>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </div>
                                <span class="text-sm text-gray-700">Match qualifications with scholarship eligibility</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Form Panel -->
                <div class="w-full max-w-lg bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center py-4">
            <p class="text-xs text-gray-400">© 2024 ScholarshipAdvisor. Empowering the next generation of global leaders.</p>
        </footer>
    </body>
</html>
