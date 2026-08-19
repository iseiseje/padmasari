@extends('layouts.app')

@section('title', 'Modul Pembelajaran - Padmasari AI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">

    <!-- Header -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-100/90 border border-amber-300/80 text-amber-900 text-xs font-bold tracking-wider mb-3">
            <i class="fa-solid fa-graduation-cap text-amber-600" aria-hidden="true"></i> Kurikulum Sastra &amp; Filologi
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif text-gray-900 tracking-tight">Modul Pembelajaran Interaktif</h1>
        <p class="text-gray-600 text-sm sm:text-base mt-3 leading-relaxed max-w-2xl mx-auto">Pelajari struktur Aksara Sunda Kuno, analisis struktur Wawacan Pupuh, dan teknik konservasi digital berbantuan AI.</p>
    </div>

    <!-- Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($modules as $module)
            <div class="bg-white rounded-3xl border border-[#e9e4e1] shadow-xs hover:shadow-md transition-all p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 bg-indigo-50 text-padma-primary text-xs font-bold rounded-md">
                            {{ $module->category }}
                        </span>
                        <span class="text-xs font-bold text-gray-500 flex items-center gap-1">
                            <i class="fa-solid fa-signal text-amber-500" aria-hidden="true"></i> {{ $module->difficulty }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold font-serif text-gray-900 mb-3 leading-snug">
                        <a href="{{ route('modules.show', $module->id) }}" class="hover:text-padma-primary transition-colors">
                            {{ $module->title }}
                        </a>
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-6">
                        {{ $module->description }}
                    </p>

                    <div class="space-y-2.5 pt-4 border-t border-gray-100 text-xs text-gray-500 font-medium">
                        <div class="flex justify-between">
                            <span>Jumlah Pelajaran:</span>
                            <span class="font-bold text-gray-900">{{ $module->lesson_count }} Pelajaran</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimasi Durasi:</span>
                            <span class="font-bold text-gray-900">{{ $module->duration_minutes }} Menit</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1.5">
                            <span>Progres Belajar</span>
                            <span class="font-bold text-padma-primary">{{ $module->progress_percent }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-padma-primary h-2 rounded-full transition-all duration-300" style="width: {{ $module->progress_percent }}%"></div>
                        </div>
                    </div>

                    <a href="{{ route('modules.show', $module->id) }}" class="tactile-btn w-full py-3 bg-padma-primary hover:bg-padma-primary-hover text-white font-bold text-xs sm:text-sm rounded-2xl shadow-xs transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-book-open" aria-hidden="true"></i> Mulai Pembelajaran
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection

