<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ScholarshipAdvisor - Find Your Perfect Scholarship</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom, #FAFAFB 0%, #F5F6F8 100%);
        }
    </style>
</head>

<body class="text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Top Navigation Bar -->
    <header class="w-full bg-white border-b border-gray-200 px-8 lg:px-24 py-4 flex items-center justify-between sticky top-0 z-50">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#2C3BEB] rounded-lg flex items-center justify-center">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 3L1 9L12 15L21 10.09V17H23V9L12 3ZM5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z" />
                </svg>
            </div>
            <span class="font-bold text-gray-900 text-base">ScholarshipAdvisor</span>
        </a>

        <!-- Nav Links -->
        <nav class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">About Us</a>
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="text-sm font-medium border border-gray-900 text-gray-900 px-4 py-1.5 rounded-md hover:bg-gray-900 hover:text-white transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="text-sm font-medium border border-gray-900 text-gray-900 px-4 py-1.5 rounded-md hover:bg-gray-900 hover:text-white transition-colors">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="text-sm font-medium border border-gray-900 text-gray-900 px-4 py-1.5 rounded-md hover:bg-gray-900 hover:text-white transition-colors">Sign
                        Up</a>
                @endif
            @endauth
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center w-full">

        <!-- Hero Section -->
        <section
            class="w-full max-w-7xl mx-auto px-8 md:px-16 lg:px-24 pt-16 pb-24 flex flex-col-reverse lg:flex-row items-center justify-between gap-16 lg:gap-20">

            <!-- Hero Text -->
            <div class="w-full lg:w-[50%] flex flex-col gap-6 text-center lg:text-left">
                <h1 class="text-[3.5rem] lg:text-[4rem] font-bold text-[#1A05A2] leading-[1.05] tracking-tight">
                    Find Your Perfect Scholarship
                </h1>

                <p class="text-gray-600 text-[1.05rem] leading-relaxed font-normal mt-2 lg:pr-8">
                    ScholarshipAdvisor is a smart platform designed to help students discover scholarships that best
                    match their academic background, eligibility, and personal qualifications. By simply creating an
                    account and entering your details, you can receive personalized scholarship recommendations quickly
                    and accurately without the hassle of manual searching. Our system compares your profile with
                    scholarship requirements to provide relevant and reliable results, helping you save time and reduce
                    the risk of applying for unsuitable opportunities. Start your journey towards a brighter future
                    today by signing up and finding the right scholarship for you.
                </p>

                <div class="pt-4">
                    <a href="{{ route('register') }}"
                        class="inline-block bg-[#0a1945] hover:bg-[#071336] text-white font-semibold text-[1rem] px-8 py-3.5 rounded-full transition-all shadow-[0_8px_20px_rgba(10,25,69,0.2)] hover:-translate-y-0.5">
                        Get Started Now
                    </a>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="w-full lg:w-[50%] flex justify-center lg:justify-end relative">
                <!-- Outer subtle shadow backdrop -->
                <div
                    class="relative w-full max-w-[550px] aspect-[1.1] shadow-[0_30px_70px_rgba(0,0,0,0.2)] transform rotate-[-1deg] overflow-hidden rounded-[2.5rem] bg-gray-100 z-10 transition-transform hover:rotate-0 duration-700 ease-in-out border-[6px] border-transparent">
                    <img src="{{ asset('images/hero.png') }}" alt="Students studying in a modern library"
                        class="w-full h-full object-cover scale-[1.02]" />
                    <div
                        class="absolute inset-0 rounded-[2.5rem] shadow-[inset_0_0_0_1px_rgba(0,0,0,0.05)] pointer-events-none">
                    </div>
                </div>
            </div>

        </section>

        <!-- CTA Section -->
        <section class="w-full max-w-[65rem] mx-auto px-8 mb-24 mt-4">
            <div
                class="w-full bg-[#1e40a6] rounded-[2.5rem] p-16 md:p-20 text-center text-white relative overflow-hidden shadow-[0_20px_50px_rgba(30,64,166,0.25)]">
                <!-- Abstract waves/shapes for background -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div
                        class="absolute -right-20 -top-20 w-[400px] h-[400px] bg-[#2a4ec9] rounded-full mix-blend-screen opacity-50 blur-3xl">
                    </div>
                    <div class="absolute -left-20 -bottom-20 w-[300px] h-[300px] bg-[#1a3899] rounded-full blur-2xl">
                    </div>
                    <!-- Right large circle mimicking the image -->
                    <div class="absolute top-0 right-0 w-[45%] h-[150%] bg-[#2545af] opacity-90 rounded-bl-[100%]">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-[40%] h-[120%] bg-[#1b3a9e] opacity-70 rounded-tr-[100%] mix-blend-multiply">
                    </div>
                </div>

                <div class="relative z-10 flex flex-col items-center gap-10">
                    <h2 class="text-4xl md:text-[2.75rem] font-bold tracking-tight text-white leading-tight">Ready to
                        unlock your potential?</h2>
                    <a href="{{ route('register') }}"
                        class="bg-white hover:bg-gray-50 text-[#1e40a6] font-bold text-[1.1rem] px-10 py-4 rounded-full transition-transform hover:scale-105 shadow-[0_10px_20px_rgba(0,0,0,0.1)]">
                        Create Your Free Account
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer Section -->
    <footer class="w-full border-t border-gray-200 bg-[#FAFAFB]">
        <div
            class="w-full max-w-7xl mx-auto px-8 md:px-16 lg:px-24 py-10 flex flex-col md:flex-row items-center justify-between gap-8">

            <div class="flex flex-col items-center md:items-start gap-1">
                <span class="text-[1.05rem] font-extrabold text-[#1a1a1a] tracking-tight">ScholarshipAdvisor</span>
                <span class="text-[0.60rem] font-bold text-gray-400 tracking-[0.05em] uppercase">© 2024
                    ScholarshipAdvisor. The scholarly editorial.</span>
            </div>

            <div class="flex flex-wrap justify-center md:justify-end items-center gap-6 md:gap-7">
                <a href="#"
                    class="text-[0.65rem] font-bold text-gray-400 hover:text-gray-600 tracking-[0.1em] transition-colors uppercase">Privacy
                    Policy</a>
                <a href="#"
                    class="text-[0.65rem] font-bold text-gray-400 hover:text-gray-600 tracking-[0.1em] transition-colors uppercase">Terms
                    of Service</a>
                <a href="#"
                    class="text-[0.65rem] font-bold text-gray-400 hover:text-gray-600 tracking-[0.1em] transition-colors uppercase">Accessibility</a>
                <a href="#"
                    class="text-[0.65rem] font-bold text-gray-400 hover:text-gray-600 tracking-[0.1em] transition-colors uppercase">Contact
                    Support</a>

                <div class="flex items-center gap-4 text-gray-400 border-l border-gray-300 pl-6 ml-2">
                    <!-- Planet / Network Icon -->
                    <svg class="w-4 h-4 cursor-pointer hover:text-gray-600 transition-colors" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                        </path>
                    </svg>
                    <!-- Asterisk/Sparkle Icon -->
                    <svg class="w-4 h-4 cursor-pointer hover:text-gray-600 transition-colors" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14M8 8l8 8M16 8l-8 8" />
                    </svg>
                    <!-- Cap Icon -->
                    <svg class="w-4 h-4 cursor-pointer hover:text-gray-600 transition-colors" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>