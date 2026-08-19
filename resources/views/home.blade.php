@extends('layouts.app')

@section('title', 'Padmasari AI - Learning Platform & Digital Heritage')

@section('content')
<!-- Viewport-Stable Hero Section -->
<section class="relative min-h-[calc(100vh-5rem)] flex flex-col justify-center pt-8 pb-16 lg:pt-12 lg:pb-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <!-- 1. Eyebrow Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100/90 border border-amber-300/80 text-amber-900 text-xs font-semibold tracking-wider">
                <i class="fa-solid fa-gem text-amber-600 text-xs" aria-hidden="true"></i> Motif Batik Sunda &amp; Warisan Budaya
            </div>
            
            <!-- 2. Display Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-serif text-gray-900 leading-[1.15] tracking-tight">
                Harmoni <span class="text-padma-primary underline decoration-amber-500/40 decoration-4">Batik Sunda</span> &amp; Kecerdasan Sastra Masa Depan
            </h1>
            
            <!-- 3. Subtext Description -->
            <p class="text-base sm:text-lg text-gray-600 leading-relaxed font-normal max-w-2xl mx-auto">
                Padmasari AI mentranskripsi, menganalisis, dan menyajikan kembali manuskrip sejarah (Wawacan, Aksara Sunda Kuno, &amp; Lontar) menjadi pengalaman belajar interaktif dan generator cerita adaptif bagi generasi muda.
            </p>

            <!-- 4. Primary & Secondary CTAs -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                <a href="{{ route('story-generator.index') }}" class="tactile-btn px-7 py-3.5 bg-padma-primary hover:bg-padma-primary-hover text-white font-bold rounded-2xl shadow-md hover:shadow-lg transition-all flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-wand-magic-sparkles text-amber-300" aria-hidden="true"></i> Coba AI Story Generator
                </a>
                <a href="{{ route('modules.index') }}" class="tactile-btn px-7 py-3.5 bg-white border border-[#e9e4e1] hover:border-padma-primary text-gray-800 font-bold rounded-2xl hover:bg-gray-50 transition-all flex items-center gap-2 text-sm shadow-xs">
                    <i class="fa-solid fa-graduation-cap text-padma-secondary" aria-hidden="true"></i> Modul Pembelajaran
                </a>
            </div>
        </div>

    </div>
</section>

<!-- Separate Social Proof Metrics Section (Outside Hero Stack) -->
<section class="py-8 bg-white border-y border-[#e9e4e1]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center text-center divide-x divide-gray-100">
            <div class="p-2">
                <span class="text-3xl sm:text-4xl font-extrabold font-serif text-padma-primary block">{{ $totalStories }}</span>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Cerita AI Dihasilkan</span>
            </div>
            <div class="p-2">
                <span class="text-3xl sm:text-4xl font-extrabold font-serif text-padma-secondary block">{{ $totalModules }}</span>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Modul Pembelajaran</span>
            </div>
            <div class="p-2">
                <span class="text-3xl sm:text-4xl font-extrabold font-serif text-amber-600 block">100%</span>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Akses Literatur Digital</span>
            </div>
            <div class="p-2">
                <span class="text-3xl sm:text-4xl font-extrabold font-serif text-emerald-700 block">Philology</span>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">NLP Nusantara Engine</span>
            </div>
        </div>
    </div>
</section>

<!-- Bento Grid Featured AI Stories Showcase -->
<section class="py-20 bg-[#fcf9f8]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-widest text-padma-secondary">Koleksi Terpopuler</span>
                <h2 class="text-3xl font-bold font-serif text-gray-900">Hasil Adaptasi Cerita AI Padmasari</h2>
            </div>
            <a href="{{ route('story-generator.index') }}" class="text-sm font-bold text-padma-primary hover:text-padma-primary-hover flex items-center gap-2 mt-4 sm:mt-0 transition-colors">
                Lihat Semua Cerita <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            @foreach($featuredStories as $index => $story)
                <div class="{{ $loop->first ? 'md:col-span-7 bg-gradient-to-br from-indigo-900 to-padma-primary text-white' : 'md:col-span-5 bg-white text-gray-900 border border-[#e9e4e1]' }} rounded-3xl p-6 sm:p-8 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $loop->first ? 'bg-amber-400 text-gray-950' : 'bg-amber-100 text-amber-900' }}">
                                {{ $story->theme }}
                            </span>
                            <span class="text-xs font-medium flex items-center gap-1.5 {{ $loop->first ? 'text-indigo-200' : 'text-gray-400' }}">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ $story->reads_count }} Dibaca
                            </span>
                        </div>

                        <h3 class="text-xl sm:text-2xl font-bold font-serif mb-3 leading-snug">
                            <a href="{{ route('story-generator.show', $story->id) }}" class="hover:underline transition-all">
                                {{ $story->title }}
                            </a>
                        </h3>

                        <p class="text-xs sm:text-sm line-clamp-3 leading-relaxed mb-6 {{ $loop->first ? 'text-indigo-100' : 'text-gray-600' }}">
                            {{ Str::limit($story->content, $loop->first ? 240 : 180) }}
                        </p>
                    </div>

                    <div class="pt-4 border-t flex items-center justify-between gap-4 {{ $loop->first ? 'border-indigo-800/80' : 'border-gray-100' }}">
                        <div class="text-xs font-serif italic truncate max-w-[240px] {{ $loop->first ? 'text-amber-200' : 'text-gray-500' }}">
                            "{{ Str::limit($story->moral_lesson, 40) }}"
                        </div>
                        <a href="{{ route('story-generator.show', $story->id) }}" class="tactile-btn text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 whitespace-nowrap {{ $loop->first ? 'bg-white text-padma-primary hover:bg-amber-100' : 'bg-indigo-50 text-padma-primary hover:bg-indigo-100' }}">
                            Baca Cerita <i class="fa-solid fa-chevron-right text-[10px]" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

