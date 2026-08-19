@extends('layouts.app')

@section('title', 'Dashboard Siswa - Padmasari AI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight">Dashboard Statistik &amp; Pembelajaran</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan aktivitas belajar &amp; generator cerita AI</p>
        </div>
        <a href="{{ route('story-generator.index') }}" class="tactile-btn px-5 py-3 bg-padma-primary hover:bg-padma-primary-hover text-white text-xs sm:text-sm font-bold rounded-2xl transition-all flex items-center justify-center gap-2 shadow-xs">
            <i class="fa-solid fa-plus" aria-hidden="true"></i> Buat Cerita AI Baru
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs">
            <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-padma-primary flex items-center justify-center text-base mb-4 font-bold">
                <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
            </div>
            <span class="text-3xl font-extrabold font-serif text-gray-900 block tracking-tight">{{ $stats['stories_created'] }}</span>
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Cerita AI Dibuat</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-padma-secondary flex items-center justify-center text-base mb-4 font-bold">
                <i class="fa-solid fa-book-open" aria-hidden="true"></i>
            </div>
            <span class="text-3xl font-extrabold font-serif text-gray-900 block tracking-tight">{{ $stats['active_modules'] }}</span>
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Modul Aktif</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-base mb-4 font-bold">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
            </div>
            <span class="text-3xl font-extrabold font-serif text-gray-900 block tracking-tight">{{ $stats['learning_hours'] }} Jam</span>
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Waktu Belajar</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs">
            <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center text-base mb-4 font-bold">
                <i class="fa-solid fa-award" aria-hidden="true"></i>
            </div>
            <span class="text-3xl font-extrabold font-serif text-gray-900 block tracking-tight">{{ $stats['certificates_earned'] }}</span>
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-1 block">Sertifikat Diperoleh</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Active Learning Modules -->
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold font-serif text-gray-900">Modul Pembelajaran Aktif</h2>
                <a href="{{ route('modules.index') }}" class="text-xs font-bold text-padma-primary hover:underline">Lihat Semua Modul</a>
            </div>

            <div class="space-y-4">
                @foreach($modules as $module)
                    <div class="bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs hover:shadow-md transition-all">
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div>
                                <span class="px-2.5 py-0.5 bg-indigo-50 text-padma-primary text-[11px] font-bold rounded-md">
                                    {{ $module->category }}
                                </span>
                                <h3 class="text-base font-bold text-gray-900 mt-2 font-serif">
                                    <a href="{{ route('modules.show', $module->id) }}" class="hover:text-padma-primary transition-colors">
                                        {{ $module->title }}
                                    </a>
                                </h3>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 whitespace-nowrap">{{ $module->lesson_count }} Pelajaran</span>
                        </div>

                        <p class="text-xs text-gray-600 mb-4 leading-relaxed">{{ $module->description }}</p>

                        <div>
                            <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1.5">
                                <span>Progres Pelajaran</span>
                                <span class="font-bold text-padma-primary">{{ $module->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-padma-primary h-2 rounded-full transition-all duration-300" style="width: {{ $module->progress_percent }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center text-xs">
                            <span class="text-gray-500"><i class="fa-solid fa-signal text-amber-500 mr-1" aria-hidden="true"></i> {{ $module->difficulty }}</span>
                            <a href="{{ route('modules.show', $module->id) }}" class="font-bold text-padma-primary hover:underline flex items-center gap-1">
                                Lanjutkan Belajar &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent AI Stories & Manuscripts -->
        <div class="lg:col-span-5 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold font-serif text-gray-900">Cerita AI Saya</h2>
                <a href="{{ route('story-generator.index') }}" class="text-xs font-bold text-padma-primary hover:underline">Generator</a>
            </div>

            <div class="bg-white rounded-3xl border border-[#e9e4e1] shadow-xs divide-y divide-gray-100 overflow-hidden">
                @foreach($recentStories as $story)
                    <div class="p-5 hover:bg-gray-50/80 transition-colors">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-padma-secondary bg-amber-50 px-2 py-0.5 rounded">{{ $story->theme }}</span>
                            <span class="text-[11px] text-gray-400 font-medium">{{ $story->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 font-serif">
                            <a href="{{ route('story-generator.show', $story->id) }}" class="hover:text-padma-primary transition-colors">
                                {{ $story->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500 line-clamp-1 mt-1 font-sans">
                            Prompt: "{{ $story->prompt }}"
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

