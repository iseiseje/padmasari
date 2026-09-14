<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Padmasari AI - Platform Pembelajaran Literatur & Manuskrip Kuno')</title>
    <meta name="description" content="Padmasari AI - Platform kecerdasan buatan terdepan untuk pelestarian, analisis, dan penyajian kembali manuskrip serta warisan literatur kuno Indonesia.">
    
    <!-- Tailwind CSS CDN Fallback for Production / VPS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'padma-primary': '#1e3a8a',
                        'padma-secondary': '#944925',
                        'padma-accent': '#d97706',
                        'padma-bg': '#f8fafc',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.04);
        }
    </style>

    <!-- Vite Standard Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine.js for lightweight UI interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased bg-slate-50 text-slate-900 selection:bg-amber-100 selection:text-amber-900">

    @unless(View::hasSection('full_page'))
    <!-- Header Navigation (Shadcn Grow Glassmorphism Style) -->
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-blue-600/20 rounded-xl p-1 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-slate-950 text-amber-400 flex items-center justify-center text-lg shadow-sm group-hover:scale-105 transition-transform duration-200 border border-slate-800">
                        <i class="fa-solid fa-feather-pointed" aria-hidden="true"></i>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="text-xl sm:text-2xl font-extrabold tracking-tight font-display text-slate-950">Padmasari</span>
                            <span class="text-[10px] font-bold tracking-widest uppercase px-2 py-0.5 bg-amber-50 text-amber-800 rounded-md border border-amber-200/80">AI</span>
                        </div>
                        <span class="text-[11px] text-slate-500 font-medium tracking-tight">Sastra &amp; Heritage Platform</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/80" aria-label="Navigasi Utama">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-xs font-bold rounded-full transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('home') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-950 hover:bg-white/60' }}">
                        <i class="fa-solid fa-house text-[11px]" aria-hidden="true"></i> Beranda
                    </a>
                    <a href="{{ route('documents.novel') }}" class="px-4 py-2 text-xs font-bold rounded-full transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('documents.novel') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-950 hover:bg-white/60' }}">
                        <i class="fa-solid fa-book text-[11px] text-amber-600" aria-hidden="true"></i> Novel
                    </a>
                    <a href="{{ route('documents.naskah') }}" class="px-4 py-2 text-xs font-bold rounded-full transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('documents.naskah') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-950 hover:bg-white/60' }}">
                        <i class="fa-solid fa-scroll text-[11px] text-emerald-600" aria-hidden="true"></i> Naskah Cerita
                    </a>
                    <a href="{{ route('documents.drama') }}" class="px-4 py-2 text-xs font-bold rounded-full transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('documents.drama') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-950 hover:bg-white/60' }}">
                        <i class="fa-solid fa-masks-theater text-[11px] text-cyan-600" aria-hidden="true"></i> Drama
                    </a>
                    <a href="{{ route('questionnaire') }}" class="px-4 py-2 text-xs font-bold rounded-full transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('questionnaire') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-950 hover:bg-white/60' }}">
                        <i class="fa-solid fa-clipboard-question text-[11px] text-indigo-600" aria-hidden="true"></i> Kuesioner
                    </a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none" aria-label="Toggle Navigation">
                        <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden py-4 border-t border-slate-200 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('home') ? 'bg-slate-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Beranda</a>
                <a href="{{ route('documents.novel') }}" class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('documents.novel') ? 'bg-slate-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Dokumen Novel</a>
                <a href="{{ route('documents.naskah') }}" class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('documents.naskah') ? 'bg-slate-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Naskah Cerita</a>
                <a href="{{ route('documents.drama') }}" class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('documents.drama') ? 'bg-slate-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Pentas Drama</a>
                <a href="{{ route('questionnaire') }}" class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('questionnaire') ? 'bg-slate-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Kuesioner</a>
            </div>
        </div>
    </header>
    @endunless

    <!-- Main Content Container -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-950 px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base" aria-hidden="true"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-800 hover:text-emerald-950 p-1" aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @unless(View::hasSection('full_page'))
    <!-- Global Footer (Shadcn Grow Dark Aesthetic) -->
    <footer class="bg-slate-950 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-14 border-b border-slate-800/80">
                <div class="md:col-span-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-amber-400 font-bold text-base shadow-sm">
                            <i class="fa-solid fa-feather-pointed" aria-hidden="true"></i>
                        </div>
                        <span class="text-2xl font-bold font-display text-white tracking-tight">Padmasari AI</span>
                    </div>
                    <p class="text-slate-400 text-sm max-w-md leading-relaxed font-normal">
                        Platform dokumentasi sastra, filologi, dan adaptasi naratif manuskrip kuno Nusantara.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="px-3 py-1 bg-slate-900 border border-slate-800 rounded-full text-xs font-semibold text-slate-400">Filologi Digital</span>
                        <span class="px-3 py-1 bg-slate-900 border border-slate-800 rounded-full text-xs font-semibold text-slate-400">Dokumen Statis</span>
                    </div>
                </div>
                <div class="md:col-span-3 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-slate-100">Navigasi Dokumen</h2>
                    <ul class="space-y-3 text-xs font-medium text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('documents.novel') }}" class="hover:text-amber-400 transition-colors">Dokumen Novel</a></li>
                        <li><a href="{{ route('documents.naskah') }}" class="hover:text-amber-400 transition-colors">Naskah Cerita</a></li>
                        <li><a href="{{ route('documents.drama') }}" class="hover:text-amber-400 transition-colors">Pentas Drama</a></li>
                        <li><a href="{{ route('questionnaire') }}" class="hover:text-amber-400 transition-colors">Kuesioner &amp; Evaluasi</a></li>
                    </ul>
                </div>
                <div class="md:col-span-3 space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-slate-100">Arsip Literatur</h2>
                    <ul class="space-y-2.5 text-xs font-medium text-slate-400">
                        <li class="flex items-center gap-2.5"><i class="fa-solid fa-file-word text-amber-500 text-xs" aria-hidden="true"></i> Statis DOCX Engine</li>
                        <li class="flex items-center gap-2.5"><i class="fa-solid fa-book-open text-amber-500 text-xs" aria-hidden="true"></i> Reader Interaktif</li>
                        <li class="flex items-center gap-2.5"><i class="fa-solid fa-book-journal-whills text-amber-500 text-xs" aria-hidden="true"></i> OCR Aksara Kuno &amp; Filologi</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                <p>&copy; 2026 Padmasari AI Platform. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-slate-300 transition-colors">Privasi</a>
                    <a href="#" class="hover:text-slate-300 transition-colors">Ketentuan</a>
                    <a href="#" class="hover:text-slate-300 transition-colors">Dokumentasi API</a>
                </div>
            </div>
        </div>
    </footer>
    @endunless

</body>
</html>


