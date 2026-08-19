<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Padmasari AI - Platform Pembelajaran Literatur & Manuskrip Kuno')</title>
    <meta name="description" content="Padmasari AI - Platform kecerdasan buatan terdepan untuk pelestarian, analisis, dan penyajian kembali manuskrip serta warisan literatur kuno Indonesia.">
    
    <!-- Vite Standard Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icon Glyph Standard -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="min-h-screen flex flex-col justify-between antialiased bg-[#fcf9f8] text-[#1c1b1b] batik-pattern-overlay selection:bg-indigo-100 selection:text-padma-primary">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-[#e9e4e1] shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-padma-primary/20 rounded-xl p-1 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-padma-primary to-padma-secondary flex items-center justify-center text-white text-lg shadow-sm group-hover:scale-105 transition-transform duration-200">
                        <i class="fa-solid fa-feather-pointed" aria-hidden="true"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl sm:text-2xl font-extrabold tracking-tight font-serif text-padma-primary">Padmasari</span>
                            <span class="text-[10px] tracking-widest uppercase font-bold px-2 py-0.5 bg-amber-100/90 text-amber-900 rounded-md border border-amber-200/60">AI</span>
                        </div>
                        <span class="text-[11px] text-gray-500 font-medium tracking-tight">Heritage &amp; Intelligence Platform</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2" aria-label="Navigasi Utama">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('home') ? 'text-padma-primary bg-indigo-50/80 shadow-xs' : 'text-gray-700 hover:text-padma-primary hover:bg-gray-100/70' }}">
                        <i class="fa-solid fa-house text-xs" aria-hidden="true"></i> Beranda
                    </a>
                    <a href="{{ route('story-generator.index') }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('story-generator.*') ? 'text-padma-primary bg-indigo-50/80 shadow-xs' : 'text-gray-700 hover:text-padma-primary hover:bg-gray-100/70' }}">
                        <i class="fa-solid fa-wand-magic-sparkles text-xs text-padma-secondary" aria-hidden="true"></i> AI Story Generator
                    </a>
                    <a href="{{ route('modules.index') }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('modules.*') ? 'text-padma-primary bg-indigo-50/80 shadow-xs' : 'text-gray-700 hover:text-padma-primary hover:bg-gray-100/70' }}">
                        <i class="fa-solid fa-graduation-cap text-xs" aria-hidden="true"></i> Modul Pembelajaran
                    </a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="tactile-btn px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-padma-secondary hover:bg-padma-secondary-hover rounded-xl shadow-xs transition-all flex items-center gap-2">
                        <i class="fa-solid fa-user-shield" aria-hidden="true"></i> Portal Admin
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-emerald-50 border border-emerald-200/80 text-emerald-900 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base" aria-hidden="true"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 p-1" aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-gray-950 text-gray-300 pt-16 pb-10 mt-20 border-t border-gray-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-12 border-b border-gray-800/80">
                <div class="md:col-span-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-padma-secondary flex items-center justify-center text-white font-bold text-base shadow-sm">
                            <i class="fa-solid fa-feather-pointed" aria-hidden="true"></i>
                        </div>
                        <span class="text-2xl font-bold font-serif text-white tracking-tight">Padmasari AI</span>
                    </div>
                    <p class="text-gray-400 text-sm max-w-md leading-relaxed">
                        Platform kecerdasan buatan terdepan untuk pelestarian, analisis, dan penyajian kembali manuskrip serta warisan literatur kuno Nusantara.
                    </p>
                </div>
                <div class="md:col-span-3 space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-200">Fitur Platform</h2>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="{{ route('story-generator.index') }}" class="hover:text-amber-400 transition-colors">AI Story Generator</a></li>
                        <li><a href="{{ route('modules.index') }}" class="hover:text-amber-400 transition-colors">Modul Filologi &amp; Aksara</a></li>
                    </ul>
                </div>
                <div class="md:col-span-3 space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-200">Teknologi &amp; Konservasi</h2>
                    <ul class="space-y-2 text-xs text-gray-400">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-microchip text-amber-500" aria-hidden="true"></i> Artificial Intelligence Model</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-book-journal-whills text-amber-500" aria-hidden="true"></i> OCR &amp; Transcription System</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-amber-500" aria-hidden="true"></i> Digital Cultural Archive</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 gap-4">
                <p>&copy; 2026 Padmasari AI Learning Platform. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-gray-300 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-gray-300 transition-colors">Syarat Ketentuan</a>
                    <a href="#" class="hover:text-gray-300 transition-colors">Dokumentasi API</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

