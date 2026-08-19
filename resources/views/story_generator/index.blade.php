@extends('layouts.app')

@section('title', 'AI Story Generator - Padmasari AI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">

    <!-- Workspace Header -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-100/90 border border-amber-300/80 text-amber-900 text-xs font-bold tracking-wider mb-3">
            <i class="fa-solid fa-wand-magic-sparkles text-amber-600" aria-hidden="true"></i> Padmasari Philology Engine
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif text-gray-900 tracking-tight">AI Story Generator</h1>
        <p class="text-gray-600 text-sm sm:text-base mt-3 leading-relaxed max-w-2xl mx-auto">Perpustakaan digital cerita sastra adaptif terintegrasi database Supabase. Generasi naskah baru dikelola secara khusus oleh Admin.</p>
    </div>

    <!-- Main Workspace Container -->
    <!-- Main Workspace Container (Full Width) -->
    <div class="mb-16">
        
        <!-- Prompt Configuration Panel / Admin Form -->
        <div class="w-full bg-white p-6 sm:p-8 rounded-3xl border border-[#e9e4e1] shadow-xs flex flex-col justify-between">
            @if(session('is_admin'))
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold font-serif text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-padma-primary" aria-hidden="true"></i> Parameter Generasi Admin
                        </h2>
                        <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-full uppercase">Admin Active</span>
                    </div>

                    <form action="{{ route('story-generator.generate') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <!-- Locked Base Master Story Banner -->
                        <div class="p-4 rounded-2xl bg-amber-50/90 border border-amber-200 text-xs space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-200/80 text-amber-950 text-[10px] font-bold uppercase tracking-wider">
                                    <i class="fa-solid fa-lock text-amber-700"></i> Naskah Master Terkunci (Acuan Utama)
                                </span>
                                <span class="text-[10px] text-amber-800 font-semibold">Tersimpan di Supabase DB</span>
                            </div>
                            <h3 class="font-serif font-bold text-gray-900 text-sm sm:text-base">{{ $masterNarrative->title }}</h3>
                            <p class="text-xs text-amber-950 font-medium">Topik: <span class="font-bold text-padma-primary">{{ $masterNarrative->core_topic }}</span></p>
                            
                            <details class="text-[11px] text-gray-700 pt-1 cursor-pointer">
                                <summary class="font-bold text-padma-primary hover:underline flex items-center gap-1 inline-flex select-none">
                                    <i class="fa-solid fa-book-open"></i> Lihat Cuplikan Naskah Master Acuan
                                </summary>
                                <div class="mt-2 p-3 bg-white/80 rounded-xl border border-amber-100 font-serif italic text-gray-800 leading-relaxed max-h-40 overflow-y-auto">
                                    "{{ $masterNarrative->master_content }}"
                                </div>
                            </details>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Fokus Adegan / Prompt Adaptasi Admin <span class="text-red-500">*</span></label>
                            <textarea name="prompt" rows="3" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm outline-none transition-all resize-none bg-gray-50/50 focus:bg-white text-gray-900 placeholder:text-gray-400" placeholder="Contoh: Buat adaptasi adegan saat Purbasari diasingkan di hutan dan pertama kali bertemu Lutung Kasarung..." required></textarea>
                        </div>

                        <!-- Natural Cardboard Interactive Theme & Genre Selector -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2.5">
                                <i class="fa-solid fa-layer-group text-padma-primary"></i> Pilihan Tema &amp; Genre Adaptasi
                            </label>
                            <input type="hidden" name="theme" id="selected_theme_input" value="Cyberpunk (Distopia Megakorporat Neo-Nusantara)">

                            <div class="flex flex-col space-y-3" id="theme_cards_container">
                                
                                <!-- Card 1: Cyberpunk -->
                                <div onclick="selectThemeCard('Cyberpunk (Distopia Megakorporat Neo-Nusantara)', this)" class="theme-card active-theme-card p-4 rounded-2xl cursor-pointer transition-all border-2 bg-amber-50/90 border-amber-500 shadow-xs ring-2 ring-amber-100/60 relative flex items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full bg-slate-900 text-cyan-300 text-[10px] font-bold uppercase tracking-wider">
                                                Cyberpunk
                                            </span>
                                            <h4 class="font-serif font-bold text-sm text-gray-900">Distopia Megakorporat Neo-Nusantara</h4>
                                        </div>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            Kota neon masa depan, smart-nano paint, hologram "Malaikat Digital", crypto-credits &amp; siberitik.
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex items-center justify-center w-7 h-7 rounded-full bg-amber-500 text-white check-icon">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </div>
                                </div>

                                <!-- Card 2: Sci-Fi Android -->
                                <div onclick="selectThemeCard('Sci-Fi Android (Era Sintetis)', this)" class="theme-card p-4 rounded-2xl cursor-pointer transition-all border border-gray-200 bg-white hover:bg-amber-50/40 hover:border-gray-300 relative flex items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full bg-indigo-950 text-indigo-200 text-[10px] font-bold uppercase tracking-wider">
                                                Sci-Fi Android
                                            </span>
                                            <h4 class="font-serif font-bold text-sm text-gray-900">Era Sintetis</h4>
                                        </div>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            Stasiun luar angkasa, Android elit vs manusia, upgrade software ilegal &amp; "System Destroyer".
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-400 check-icon hidden">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </div>
                                </div>

                                <!-- Card 3: Steampunk -->
                                <div onclick="selectThemeCard('Steampunk (Revolusi Industri Mekanik)', this)" class="theme-card p-4 rounded-2xl cursor-pointer transition-all border border-gray-200 bg-white hover:bg-amber-50/40 hover:border-gray-300 relative flex items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full bg-stone-900 text-amber-200 text-[10px] font-bold uppercase tracking-wider">
                                                Steampunk
                                            </span>
                                            <h4 class="font-serif font-bold text-sm text-gray-900">Revolusi Industri Mekanik</h4>
                                        </div>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            Kota kabut uap &amp; kuningan, bangsawan industrialis, glider uap &amp; Automaton peluit mekanik.
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-400 check-icon hidden">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </div>
                                </div>

                                <!-- Card 4: Post-Apocalyptic -->
                                <div onclick="selectThemeCard('Post-Apocalyptic (Dunia Pasca-Kiamat)', this)" class="theme-card p-4 rounded-2xl cursor-pointer transition-all border border-gray-200 bg-white hover:bg-amber-50/40 hover:border-gray-300 relative flex items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-950 text-emerald-200 text-[10px] font-bold uppercase tracking-wider">
                                                Post-Apocalyptic
                                            </span>
                                            <h4 class="font-serif font-bold text-sm text-gray-900">Dunia Pasca-Kiamat</h4>
                                        </div>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            Wasteland tandus, warlord pemurni air, debu radioaktif bersinar &amp; scrap armor monster mutan.
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-400 check-icon hidden">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Target Pembaca</label>
                                <select name="target_audience" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm text-gray-800 bg-white focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 outline-none">
                                    <option value="Remaja & Mahasiswa">Remaja &amp; Mahasiswa</option>
                                    <option value="Anak-Anak">Anak-Anak (Bahasa Sederhana)</option>
                                    <option value="Umum & Peneliti">Umum &amp; Peneliti Budaya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Pesan Moral yang Ditekankan</label>
                                <input type="text" name="moral_lesson" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm outline-none bg-gray-50/50 focus:bg-white text-gray-900" placeholder="Pesan moral..." value="Kecerdikan dan ketulusan niat mengalahkan keserakahan.">
                            </div>
                        </div>

                        <script>
                            function selectThemeCard(themeValue, el) {
                                document.getElementById('selected_theme_input').value = themeValue;
                                const cards = document.querySelectorAll('#theme_cards_container .theme-card');
                                cards.forEach(c => {
                                    c.className = "theme-card p-4 rounded-2xl cursor-pointer transition-all border border-gray-200 bg-white hover:bg-amber-50/40 hover:border-gray-300 relative flex items-center justify-between gap-4";
                                    const icon = c.querySelector('.check-icon');
                                    if(icon) {
                                        icon.className = "shrink-0 flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-400 check-icon hidden";
                                    }
                                });

                                el.className = "theme-card active-theme-card p-4 rounded-2xl cursor-pointer transition-all border-2 bg-amber-50/90 border-amber-500 shadow-xs ring-2 ring-amber-100/60 relative flex items-center justify-between gap-4";
                                const checkIcon = el.querySelector('.check-icon');
                                if(checkIcon) {
                                    checkIcon.className = "shrink-0 flex items-center justify-center w-7 h-7 rounded-full bg-amber-500 text-white check-icon";
                                }
                            }
                        </script>


                        <button type="submit" class="tactile-btn w-full py-4 bg-padma-primary hover:bg-padma-primary-hover text-white font-bold rounded-2xl shadow-xs transition-all flex items-center justify-center gap-2 text-sm sm:text-base mt-2">
                            <i class="fa-solid fa-wand-magic-sparkles text-amber-300" aria-hidden="true"></i> Generate &amp; Simpan ke Database Supabase
                        </button>
                    </form>
                </div>
            @else
                <div class="my-auto py-6 text-center space-y-4">
                    <div class="w-14 h-14 bg-indigo-50 text-padma-primary rounded-2xl flex items-center justify-center mx-auto text-xl shadow-xs">
                        <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
                    </div>
                    <h2 class="text-xl font-bold font-serif text-gray-900">Generasi Cerita Terkurasi Admin</h2>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-md mx-auto">
                        Generasi naskah dan publikasi cerita AI Padmasari dikelola terpusat oleh Admin dan tersimpan aman di database Supabase Cloud.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('admin.login') }}" class="tactile-btn inline-flex items-center gap-2 px-5 py-2.5 bg-padma-primary hover:bg-padma-primary-hover text-white text-xs font-bold rounded-xl transition-all shadow-xs">
                            <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Login Portal Admin
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>


    <!-- Global Public Showcase -->
    <div class="pt-12 border-t border-[#e9e4e1]">
        <h2 class="text-2xl font-bold font-serif text-gray-900 mb-8">Koleksi Cerita Dipublikasikan (Supabase DB)</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentStories as $story)
                <div class="bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 bg-amber-100 text-amber-900 text-[11px] font-bold rounded-md">
                                {{ $story->theme }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">{{ $story->created_at->diffForHumans() }}</span>
                        </div>

                        <h3 class="text-lg font-bold font-serif text-gray-900 mb-2">
                            <a href="{{ route('story-generator.show', $story->id) }}" class="hover:text-padma-primary transition-colors">
                                {{ $story->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-600 line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit($story->content, 160) }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500"><i class="fa-solid fa-eye mr-1" aria-hidden="true"></i> {{ $story->reads_count }} Dibaca</span>
                        <a href="{{ route('story-generator.show', $story->id) }}" class="text-xs font-bold text-padma-primary hover:underline flex items-center gap-1">
                            Baca Cerita &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection


