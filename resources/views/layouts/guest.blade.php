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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Faculty+Glyphic&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Averia+Libre:ital@1&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .faculty-glyphic-regular {
            font-family: "Faculty Glyphic", sans-serif;
            font-weight: bold;
            font-style: normal;
        }

        .averia-libre-regular-italic {
            font-family: "Averia Libre", system-ui;
            font-weight: 400;
            font-style: italic;
        }
    </style>
</head>

<body class="antialiased min-h-screen relative overflow-x-hidden"
    style="background-image: url('/images/login_bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

    <!-- Blur Overlay -->
    <div class="fixed inset-0 z-[-1] bg-white/45"></div>


    <!-- Top Navigation Bar -->
    <header id="main-nav" class="sticky top-0 z-50 w-full transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="ScholarshipAdvisor Logo"
                        class="h-20 md:h-24 w-auto object-contain" />
                    <!-- <span
                        class="faculty-glyphic-regular text-gray-900 text-base hidden sm:inline">ScholarshipAdvisor</span>
                </a>

                <!-- Nav Links -->
                    <nav class="flex items-center gap-6">
                        <a href="{{ url('/') }}"
                            class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">About
                            Us</a>
                        @if (request()->routeIs('login'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 text-sm font-bold border border-blue-200 text-[#2C3BEB] px-5 py-2 rounded-xl hover:bg-blue-50 transition-all shadow-sm">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Sign Up
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 text-sm font-bold border border-blue-200 text-[#2C3BEB] px-5 py-2 rounded-xl hover:bg-blue-50 transition-all shadow-sm">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" />
                                </svg>
                                Login
                            </a>
                        @endif
                    </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex items-center justify-center px-4 sm:px-6 py-6" style="min-height: calc(100vh - 88px);">
        <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center lg:items-start gap-6 lg:gap-8">

            <!-- Left Hero Panel -->
            <div
                class="flex-1 max-w-md mx-auto w-full lg:mt-6 {{ request()->routeIs('login') ? '' : 'lg:sticky lg:top-32' }}">
                <div
                    class="inline-flex items-center gap-2 bg-white border border-blue-200 text-blue-700 text-[11px] font-semibold px-3 py-1 rounded-full mb-4">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                    VERIFIED SCHOLARSHIPS ONLY
                </div>

                <h1 class="faculty-glyphic-regular text-4xl lg:text-5xl text-gray-900 leading-tight mb-0">
                    Scholarship
                </h1>
                <h1 class="faculty-glyphic-regular text-4xl lg:text-5xl text-[#2C3BEB] leading-tight mb-3">
                    Advisor
                </h1>

                <p class="averia-libre-regular-italic  text-sm leading-relaxed mb-5">
                    Centralized scholarship information and personalized recommendations to help you fund your academic
                    journey.
                </p>

                <div class="space-y-4">
                    @if (request()->routeIs('login'))
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.35-4.35" />
                                </svg>
                            </div>
                            <span class="averia-libre-regular-italic text-sm">Discover 10,000+ active
                                grants</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                                    <path d="M2 17l10 5 10-5" />
                                    <path d="M2 12l10 5 10-5" />
                                </svg>
                            </div>
                            <span class="averia-libre-regular-italic text-sm">AI-powered eligibility
                                matching</span>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                                    <path d="M2 17l10 5 10-5" />
                                    <path d="M2 12l10 5 10-5" />
                                </svg>
                            </div>
                            <span class="averia-libre-regular-italic text-sm text-gray-700">Match qualifications with
                                scholarship eligibility</span>
                        </div>
                    @endif
                </div>


            </div>

            <!-- Right Form Panel -->
            <div
                class="w-full max-w-lg bg-white/95 backdrop-blur-sm rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 sm:p-8 relative z-10">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Footer -->
    <!-- <footer class="text-center py-4">
        <p class="text-xs text-gray-400">© 2026 ScholarshipAdvisor
        </p>
    </footer> -->

    <script>
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                nav.classList.add('bg-white/90', 'backdrop-blur-md', 'border-b', 'border-gray-200', 'shadow-sm');
            } else {
                nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'border-b', 'border-gray-200', 'shadow-sm');
            }
        });
    </script>
</body>

</html>