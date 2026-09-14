@extends('layouts.app')

@section('title', $document['title'] . ' - Padmasari AI')

@section('content')
<div x-data="{ 
    fontSize: 'text-base', 
    themeMode: 'light', 
    fontFamily: 'font-serif',
    activeCharFilter: null,
    readingProgress: 0,

    setFontSize(size) { this.fontSize = size; },
    setThemeMode(mode) { this.themeMode = mode; },
    setFontFamily(font) { this.fontFamily = font; },
    toggleCharacterFilter(charName) {
        if (this.activeCharFilter === charName) {
            this.activeCharFilter = null;
        } else {
            this.activeCharFilter = charName;
        }
    },
    updateProgress() {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        this.readingProgress = height > 0 ? Math.round((winScroll / height) * 100) : 0;
    }
}" 
x-init="window.addEventListener('scroll', () => updateProgress())"
class="min-h-screen transition-colors duration-300"
:class="{
    'bg-slate-950 text-slate-100': themeMode === 'dark',
    'bg-slate-100 text-slate-900': themeMode === 'light'
}">

    <!-- Sticky Reading Progress Bar -->
    <div class="fixed top-0 left-0 right-0 h-1.5 bg-slate-200 dark:bg-slate-800 z-50 pointer-events-none">
        <div class="h-full bg-amber-500 transition-all duration-150" :style="`width: ${readingProgress}%`"></div>
    </div>

    <!-- Header Navigation & Reader Toolkit Bar -->
    <div class="sticky top-0 z-40 backdrop-blur-xl border-b py-3 px-4 sm:px-8 transition-colors duration-300"
         :class="{
            'bg-slate-900/95 border-slate-800 text-slate-100': themeMode === 'dark',
            'bg-white/95 border-slate-200 text-slate-900 shadow-xs': themeMode === 'light'
         }">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4">
            
            <!-- Left Back Navigation -->
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold transition-colors"
               :class="{ 'text-slate-200 hover:text-white': themeMode === 'dark', 'text-slate-900 hover:text-blue-600': themeMode === 'light' }">
                <i class="fa-solid fa-arrow-left text-xs"></i> Beranda Utama
            </a>

            <!-- Center Title Badge -->
            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1 text-xs font-extrabold font-display rounded-full uppercase tracking-wider border shadow-xs"
                      :class="{
                        'bg-slate-800 text-slate-100 border-slate-700': themeMode === 'dark',
                        'bg-slate-200 text-slate-900 border-slate-300': themeMode === 'light'
                      }">
                    {{ $document['title'] }}
                </span>
                <span class="hidden md:inline-block text-xs font-mono font-bold"
                      :class="{ 'text-slate-300': themeMode === 'dark', 'text-slate-800': themeMode === 'light' }"
                      x-text="`${readingProgress}% dibaca`"></span>
            </div>

            <!-- Right Reader Customizer Toolkit -->
            <div class="flex items-center gap-2 sm:gap-4">
                
                <!-- Font Family Switcher -->
                <div class="flex items-center p-1 rounded-xl border text-xs font-bold transition-colors"
                     :class="{ 'bg-slate-950/60 border-slate-700': themeMode === 'dark', 'bg-slate-200/90 border-slate-300': themeMode === 'light' }">
                    <button @click="setFontFamily('font-serif')" class="px-3 py-1 rounded-lg transition-all" :class="fontFamily === 'font-serif' ? 'bg-slate-900 text-white font-extrabold shadow-xs' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">Serif</button>
                    <button @click="setFontFamily('font-sans')" class="px-3 py-1 rounded-lg transition-all ml-1" :class="fontFamily === 'font-sans' ? 'bg-slate-900 text-white font-extrabold shadow-xs' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">Sans</button>
                </div>

                <!-- Font Size Switcher -->
                <div class="flex items-center p-1 rounded-xl border text-xs font-bold transition-colors"
                     :class="{ 'bg-slate-950/60 border-slate-700': themeMode === 'dark', 'bg-slate-200/90 border-slate-300': themeMode === 'light' }">
                    <button @click="setFontSize('text-sm')" class="px-2.5 py-1 rounded-lg transition-all" :class="fontSize === 'text-sm' ? 'bg-slate-900 text-white font-extrabold shadow-xs' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">A-</button>
                    <button @click="setFontSize('text-base')" class="px-2.5 py-1 rounded-lg transition-all ml-1" :class="fontSize === 'text-base' ? 'bg-slate-900 text-white font-extrabold shadow-xs' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">A</button>
                    <button @click="setFontSize('text-xl')" class="px-2.5 py-1 rounded-lg transition-all ml-1" :class="fontSize === 'text-xl' ? 'bg-slate-900 text-white font-extrabold shadow-xs' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">A+</button>
                </div>

                <!-- 2-Mode Color Theme Switcher (Light & Dark) -->
                <div class="flex items-center p-1 rounded-xl border text-xs font-bold transition-colors"
                     :class="{ 'bg-slate-950/60 border-slate-700': themeMode === 'dark', 'bg-slate-200/90 border-slate-300': themeMode === 'light' }">
                    <button @click="setThemeMode('light')" class="px-3.5 py-1 rounded-lg transition-all flex items-center gap-1.5" :class="themeMode === 'light' ? 'bg-white text-slate-950 shadow-xs border border-slate-300 font-extrabold' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">
                        <i class="fa-solid fa-sun text-amber-600"></i> Light
                    </button>
                    <button @click="setThemeMode('dark')" class="px-3.5 py-1 rounded-lg transition-all flex items-center gap-1.5 ml-1" :class="themeMode === 'dark' ? 'bg-slate-950 text-white shadow-xs border border-slate-700 font-extrabold' : (themeMode === 'dark' ? 'text-slate-300 hover:text-white' : 'text-slate-800 hover:text-slate-950')">
                        <i class="fa-solid fa-moon text-indigo-400"></i> Dark
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Container: Table of Contents Sidebar + Document Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Sticky Sidebar: Table of Contents & Character Filter -->
            <aside class="lg:col-span-3 space-y-6">
                <div class="sticky top-24 p-6 rounded-3xl border transition-colors duration-300"
                     :class="{
                        'bg-slate-900 border-slate-800 text-slate-100 shadow-xl': themeMode === 'dark',
                        'bg-white border-slate-200 text-slate-900 shadow-md': themeMode === 'light'
                     }">
                    
                    <!-- Table of Contents Header -->
                    <div class="flex items-center justify-between border-b pb-3 mb-4"
                         :class="{ 'border-slate-800': themeMode === 'dark', 'border-slate-200': themeMode === 'light' }">
                        <span class="text-xs font-extrabold uppercase tracking-widest flex items-center gap-2"
                              :class="{ 'text-slate-100': themeMode === 'dark', 'text-slate-950': themeMode === 'light' }">
                            <i class="fa-solid fa-list-ul" :class="{ 'text-slate-300': themeMode === 'dark', 'text-slate-700': themeMode === 'light' }"></i> Navigasi Bab
                        </span>
                        <span class="text-[10px] font-mono px-2.5 py-0.5 rounded-full border font-extrabold"
                              :class="{ 'bg-slate-800 text-slate-200 border-slate-700': themeMode === 'dark', 'bg-slate-100 text-slate-900 border-slate-300': themeMode === 'light' }">
                            {{ count($document['sections']) }} Bagian
                        </span>
                    </div>

                    <!-- Sections List -->
                    <nav class="space-y-1.5 max-h-[50vh] overflow-y-auto pr-1">
                        @foreach($document['sections'] as $sec)
                            <a href="#{{ $sec['id'] }}" 
                               class="block px-3 py-2 text-xs font-bold rounded-xl transition-all truncate hover:translate-x-1"
                               :class="{
                                    'text-slate-300 hover:bg-slate-800 hover:text-white': themeMode === 'dark',
                                    'text-slate-800 hover:bg-slate-100 hover:text-blue-600': themeMode === 'light'
                               }">
                                <i class="fa-solid fa-chevron-right text-[9px] mr-1.5" :class="{ 'text-slate-500': themeMode === 'dark', 'text-slate-400': themeMode === 'light' }"></i>
                                {{ $sec['title'] }}
                            </a>
                        @endforeach
                    </nav>

                    <!-- Character Filter Box (If Characters Present) -->
                    @if(count($document['characters']) > 0)
                        <div class="pt-6 border-t mt-6" :class="{ 'border-slate-800': themeMode === 'dark', 'border-slate-200': themeMode === 'light' }">
                            <div class="text-[11px] font-extrabold uppercase tracking-widest mb-3 flex items-center gap-2"
                                 :class="{ 'text-slate-100': themeMode === 'dark', 'text-slate-950': themeMode === 'light' }">
                                <i class="fa-solid fa-users" :class="{ 'text-slate-300': themeMode === 'dark', 'text-slate-700': themeMode === 'light' }"></i> Sorot Dialog Tokoh
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($document['characters'] as $char)
                                    <button @click="toggleCharacterFilter('{{ $char }}')" 
                                            class="px-2.5 py-1 text-[10px] font-bold font-mono rounded-lg border transition-all"
                                            :class="activeCharFilter === '{{ $char }}' ? 'bg-slate-900 text-white border-slate-900 shadow-xs font-black' : (themeMode === 'dark' ? 'bg-slate-800 text-slate-200 border-slate-700 hover:bg-slate-700' : 'bg-slate-100 text-slate-900 border-slate-300 hover:bg-slate-200')">
                                        {{ $char }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </aside>

            <!-- Document Text Body Container -->
            <main class="lg:col-span-9">
                <article class="p-6 sm:p-12 rounded-3xl border shadow-lg transition-colors duration-300"
                         :class="{
                            'bg-slate-900 border-slate-800 text-slate-100': themeMode === 'dark',
                            'bg-white border-slate-200 text-slate-900': themeMode === 'light'
                         }">
                    
                    <!-- Document Header -->
                    <header class="mb-10 pb-8 border-b" :class="{ 'border-slate-800': themeMode === 'dark', 'border-slate-200': themeMode === 'light' }">
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <span class="px-3.5 py-1 text-xs font-bold rounded-full uppercase tracking-wider border"
                                  :class="{ 'bg-slate-800 text-slate-200 border-slate-700': themeMode === 'dark', 'bg-slate-100 text-slate-900 border-slate-300': themeMode === 'light' }">
                                {{ $document['theme'] ?: 'Kedaulatan & Emansipasi Perempuan' }}
                            </span>
                            <span class="text-xs font-mono ml-auto" :class="{ 'text-slate-400': themeMode === 'dark', 'text-slate-600': themeMode === 'light' }">
                                Dokumen Resmi Statis &bull; resources/dokumen/
                            </span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black font-serif leading-tight tracking-tight mb-4 transition-colors"
                            :class="{ 'text-white': themeMode === 'dark', 'text-slate-950': themeMode === 'light' }">
                            {{ $document['title'] }}
                        </h1>
                    </header>

                    <!-- Document Formatted Content -->
                    <div class="document-content space-y-6" :class="[fontSize, fontFamily]">
                        {!! $document['formatted_html'] !!}
                    </div>

                    <!-- Footer Action Buttons -->
                    <footer class="mt-12 pt-8 border-t flex flex-wrap items-center justify-between gap-4"
                            :class="{ 'border-slate-800': themeMode === 'dark', 'border-slate-200': themeMode === 'light' }">
                        <div class="flex items-center gap-3">
                            <button onclick="navigator.clipboard.writeText(document.querySelector('.document-content').innerText); alert('Teks dokumen berhasil disalin!')" 
                                    class="px-4 py-2.5 text-xs font-bold rounded-xl transition-all flex items-center gap-2 shadow-xs"
                                    :class="{ 'bg-slate-800 hover:bg-slate-700 text-slate-200': themeMode === 'dark', 'bg-slate-100 hover:bg-slate-200 text-slate-900 border border-slate-300': themeMode === 'light' }">
                                <i class="fa-regular fa-copy"></i> Salin Teks Dokumen
                            </button>
                        </div>
                        <a href="{{ route('home') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-2 shadow-md">
                            <i class="fa-solid fa-house"></i> Kembali ke Beranda Utama
                        </a>
                    </footer>

                </article>
            </main>

        </div>
    </div>

</div>
@endsection
