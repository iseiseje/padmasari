@extends('layouts.app')

@section('title', 'Padmasari AI - Platform Pembelajaran Literatur & Manuskrip Kuno')

@section('content')
<!-- 1. Viewport-Stable Hero Section (Shadcn Grow Style) -->
<section class="relative min-h-[calc(100vh-5rem)] flex flex-col justify-center pt-10 pb-20 overflow-hidden subtle-grid-pattern">
    <!-- Subtle Background Ambient Highlights -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-blue-400/10 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-4xl mx-auto text-center space-y-8">
            
            <!-- 1.A Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-xs text-slate-800 text-xs font-bold tracking-tight">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Padmasari AI Engine v2.0</span>
                <span class="text-slate-300">|</span>
                <span class="text-amber-700 font-semibold">Manuskrip &amp; Sastra Sunda</span>
            </div>
            
            <!-- 1.B Display Headline -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold font-display text-slate-950 leading-[1.08] tracking-tight">
                Harmoni <span class="bg-gradient-to-r from-blue-700 via-indigo-800 to-amber-700 bg-clip-text text-transparent">Sastra Sunda</span> &amp; Kecerdasan Masa Depan
            </h1>
            
            <!-- 1.C Subtext Description (<= 20 words) -->
            <p class="text-base sm:text-xl text-slate-600 leading-relaxed font-normal max-w-2xl mx-auto">
                Transkripsi filologi dan adaptasi naratif manuskrip kuno (Wawacan &amp; Lontar) menjadi cerita interaktif multi-genre berbasis AI.
            </p>

            <!-- 1.D Dual Primary & Secondary CTAs -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <a href="{{ route('story-generator.index') }}" class="tactile-btn px-8 py-4 bg-slate-950 hover:bg-slate-900 text-white font-bold rounded-full shadow-md transition-all flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-wand-magic-sparkles text-amber-400" aria-hidden="true"></i>
                    <span>Coba AI Story Generator</span>
                </a>
                <a href="{{ route('modules.index') }}" class="tactile-btn px-8 py-4 bg-white border border-slate-300 hover:border-slate-400 text-slate-900 font-bold rounded-full hover:bg-slate-50 transition-all flex items-center gap-2 text-sm shadow-xs">
                    <i class="fa-solid fa-graduation-cap text-slate-600" aria-hidden="true"></i>
                    <span>Modul Pembelajaran</span>
                </a>
            </div>

            <!-- 1.E Trust Micro-Badges Strip -->
            <div class="pt-8 flex flex-wrap items-center justify-center gap-8 text-xs font-semibold text-slate-500 border-t border-slate-200/80 max-w-2xl mx-auto">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600" aria-hidden="true"></i>
                    <span>Aksara Sunda Kuno OCR</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600" aria-hidden="true"></i>
                    <span>NLP Filologi Nusantara</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600" aria-hidden="true"></i>
                    <span>Supabase Cloud Connected</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 2. Metrics Counter Section (Shadcn Grow Metrics Strip) -->
<section class="py-10 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center text-center divide-x divide-slate-100">
            <div class="p-2">
                <span class="text-3xl sm:text-5xl font-extrabold font-display text-slate-950 block">{{ $totalStories }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2 block">Cerita AI Dihasilkan</span>
            </div>
            <div class="p-2">
                <span class="text-3xl sm:text-5xl font-extrabold font-display text-amber-600 block">{{ $totalModules }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2 block">Modul Pembelajaran</span>
            </div>
            <div class="p-2">
                <span class="text-3xl sm:text-5xl font-extrabold font-display text-blue-800 block">100%</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2 block">Akses Literatur Digital</span>
            </div>
            <div class="p-2">
                <span class="text-3xl sm:text-5xl font-extrabold font-display text-emerald-600 block">Philology</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-2 block">NLP Nusantara Engine</span>
            </div>
        </div>
    </div>
</section>

<!-- 3. 4-Step Interactive Process Cards ("Cara Kerja Padmasari AI") -->
<section class="py-24 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-16 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-700 px-3 py-1 bg-amber-50 rounded-full border border-amber-200/80">Alur Platform</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-display text-slate-950">Cara Kerja Padmasari AI</h2>
            <p class="text-slate-600 text-base">Proses transformasi narasi manuskrip sejarah menjadi pengalaman belajar digital interaktif.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="glass-card p-8 rounded-3xl relative group hover:border-slate-400 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-slate-950 text-white flex items-center justify-center font-bold text-lg mb-6 group-hover:scale-110 transition-transform">
                    01
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2">Pilih Manuskrip Kuno</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pilih sumber naskah (Wawacan, Aksara Sunda Kuno, Lontar) dan narator master sebagai pijakan cerita.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="glass-card p-8 rounded-3xl relative group hover:border-slate-400 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-800 text-white flex items-center justify-center font-bold text-lg mb-6 group-hover:scale-110 transition-transform">
                    02
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2">Pilih Genre Adaptasi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Tentukan genre cerita modern seperti Cyberpunk, Sci-Fi, Steampunk, atau Post-Apocalyptic.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="glass-card p-8 rounded-3xl relative group hover:border-slate-400 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-bold text-lg mb-6 group-hover:scale-110 transition-transform">
                    03
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2">AI Generasi &amp; Filologi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Engine AI memproses narasi dengan menjaga esensi moral asli manuskrip filologi Sunda.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="glass-card p-8 rounded-3xl relative group hover:border-slate-400 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-emerald-700 text-white flex items-center justify-center font-bold text-lg mb-6 group-hover:scale-110 transition-transform">
                    04
                </div>
                <h3 class="text-lg font-bold text-slate-950 mb-2">Eksplorasi &amp; Belajar</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Baca hasil adaptasi cerita, pelajari struktur aksara, dan selesaikan modul pembelajaran interaktif.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Asymmetric Bento Grid Showcase (Featured Stories) -->
<section class="py-24 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-blue-800 px-3 py-1 bg-blue-50 rounded-full">Koleksi Pilihan</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-display text-slate-950">Hasil Adaptasi Cerita AI</h2>
            </div>
            <a href="{{ route('story-generator.index') }}" class="tactile-btn text-xs font-bold text-slate-900 hover:text-blue-800 flex items-center gap-2 mt-4 sm:mt-0 transition-colors">
                <span>Lihat Semua Koleksi</span>
                <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
            </a>
        </div>

        <!-- Asymmetric Bento Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            @foreach($featuredStories as $index => $story)
                <div class="{{ $loop->first ? 'md:col-span-7 bg-slate-950 text-white' : 'md:col-span-5 bg-white text-slate-950 border border-slate-200' }} rounded-3xl p-8 shadow-xs hover:shadow-lg transition-all flex flex-col justify-between group relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="px-3.5 py-1 rounded-full text-xs font-bold {{ $loop->first ? 'bg-amber-400 text-slate-950' : 'bg-slate-100 text-slate-800' }}">
                                {{ $story->theme }}
                            </span>
                            <span class="text-xs font-semibold flex items-center gap-1.5 {{ $loop->first ? 'text-slate-400' : 'text-slate-500' }}">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ $story->reads_count }} Dibaca
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold font-display mb-4 leading-snug">
                            <a href="{{ route('story-generator.show', $story->id) }}" class="hover:underline transition-all">
                                {{ $story->title }}
                            </a>
                        </h3>

                        <p class="text-sm line-clamp-3 leading-relaxed mb-8 {{ $loop->first ? 'text-slate-300' : 'text-slate-600' }}">
                            {{ Str::limit($story->content, $loop->first ? 220 : 160) }}
                        </p>
                    </div>

                    <div class="pt-6 border-t flex items-center justify-between gap-4 {{ $loop->first ? 'border-slate-800' : 'border-slate-100' }}">
                        <div class="text-xs font-serif italic truncate max-w-[240px] {{ $loop->first ? 'text-amber-300' : 'text-slate-500' }}">
                            "{{ Str::limit($story->moral_lesson, 40) }}"
                        </div>
                        <a href="{{ route('story-generator.show', $story->id) }}" class="tactile-btn text-xs font-bold px-4 py-2.5 rounded-full flex items-center gap-2 whitespace-nowrap {{ $loop->first ? 'bg-white text-slate-950 hover:bg-amber-100' : 'bg-slate-900 text-white hover:bg-slate-800' }}">
                            <span>Baca Cerita</span>
                            <i class="fa-solid fa-chevron-right text-[10px]" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 5. Capability Bento Feature Matrix -->
<section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-16 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-400 px-3 py-1 bg-slate-800 rounded-full border border-slate-700">Teknologi Terdepan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-display text-white">Inovasi Konservasi Literasi</h2>
            <p class="text-slate-400 text-base">Fitur unggulan yang menghubungkan kearifan lokal Sunda dengan kecerdasan buatan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-card-dark p-8 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-400/10 text-amber-400 border border-amber-400/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Multi-Genre Adaptor</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Mentransformasi naskah Sunda kuno ke dalam setting Cyberpunk, Sci-Fi, dan Steampunk tanpa mengubah inti pesan moral.
                </p>
            </div>

            <div class="glass-card-dark p-8 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-400/10 text-blue-400 border border-blue-400/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-microchip" aria-hidden="true"></i>
                </div>
                <h3 class="text-xl font-bold text-white">OCR Aksara Sunda</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem pengenalan karakter digital untuk mendokumentasikan lembaran naskah lontar ke teks terstruktur.
                </p>
            </div>

            <div class="glass-card-dark p-8 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Modul Interaktif</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Materi pembelajaran komprehensif bagi mahasiswa dan akademisi filologi dalam memahami aksara &amp; budaya Sunda.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 6. FAQ Accordion Section (Alpine.js Interactive) -->
<section class="py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-500">Pertanyaan Umum</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-display text-slate-950">Pertanyaan Sering Diajukan</h2>
        </div>

        <div class="space-y-4" x-data="{ activeAccordion: null }">
            <!-- FAQ Item 1 -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)" type="button" class="w-full px-6 py-5 text-left font-bold text-slate-950 flex justify-between items-center text-base focus:outline-none">
                    <span>Apakah Padmasari AI gratis digunakan?</span>
                    <i class="fa-solid" :class="activeAccordion === 1 ? 'fa-chevron-up text-amber-600' : 'fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="activeAccordion === 1" x-transition class="px-6 pb-6 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Ya! Seluruh fitur eksplorasi cerita AI, pembacaan naskah, dan modul pembelajaran dapat diakses secara publik dan gratis untuk mendukung pendidikan.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)" type="button" class="w-full px-6 py-5 text-left font-bold text-slate-950 flex justify-between items-center text-base focus:outline-none">
                    <span>Bagaimana AI menjaga keaslian nilai moral naskah kuno?</span>
                    <i class="fa-solid" :class="activeAccordion === 2 ? 'fa-chevron-up text-amber-600' : 'fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="activeAccordion === 2" x-transition class="px-6 pb-6 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Engine Padmasari AI menggunakan template *Master Narrative* yang terkunci untuk memastikan struktur moral, esensi filosofi Sunda, dan pesan naskah asli tetap utuh selama proses adaptasi genre.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)" type="button" class="w-full px-6 py-5 text-left font-bold text-slate-950 flex justify-between items-center text-base focus:outline-none">
                    <span>Apakah data cerita tersimpan di cloud?</span>
                    <i class="fa-solid" :class="activeAccordion === 3 ? 'fa-chevron-up text-amber-600' : 'fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="activeAccordion === 3" x-transition class="px-6 pb-6 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Seluruh cerita dan modul pembelajaran tersimpan secara aman di Supabase PostgreSQL Database, dapat diakses dengan cepat dan terpercaya dari mana saja.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. High-Converting CTA Banner Section -->
<section class="py-20 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 text-white relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8 relative z-10">
        <h2 class="text-3xl sm:text-5xl font-extrabold font-display text-white tracking-tight">
            Siap Mengeksplorasi Sastra Sunda dengan AI?
        </h2>
        <p class="text-slate-300 text-base sm:text-lg max-w-xl mx-auto font-normal">
            Mulai eksplorasi cerita adaptif atau pelajari modul aksara filologi Sunda secara gratis hari ini.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
            <a href="{{ route('story-generator.index') }}" class="tactile-btn px-8 py-4 bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold rounded-full shadow-lg transition-all flex items-center gap-3 text-sm">
                <i class="fa-solid fa-wand-magic-sparkles text-slate-950" aria-hidden="true"></i>
                <span>Mulai Generasi Cerita</span>
            </a>
            <a href="{{ route('modules.index') }}" class="tactile-btn px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-full border border-slate-700 transition-all flex items-center gap-2 text-sm">
                <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                <span>Lihat Modul Pembelajaran</span>
            </a>
        </div>
    </div>
</section>
@endsection


