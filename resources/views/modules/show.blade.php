@extends('layouts.app')

@section('title', $module->title . ' - Modul Pembelajaran Padmasari AI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">

    <!-- Back Navigation -->
    <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-padma-primary hover:text-padma-primary-hover mb-8 transition-colors">
        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i> Kembali ke Daftar Modul
    </a>

    <!-- Module Banner -->
    <div class="bg-white rounded-3xl border border-[#e9e4e1] p-6 sm:p-10 mb-8 shadow-xs">
        <div class="flex items-center gap-3 mb-4">
            <span class="px-3 py-1 bg-indigo-50 text-padma-primary text-[11px] font-bold rounded-full">
                {{ $module->category }}
            </span>
            <span class="px-3 py-1 bg-amber-100 text-amber-900 text-[11px] font-bold rounded-full flex items-center gap-1">
                <i class="fa-solid fa-signal" aria-hidden="true"></i> {{ $module->difficulty }}
            </span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold font-serif text-gray-900 mb-3 tracking-tight">
            {{ $module->title }}
        </h1>

        <p class="text-sm sm:text-base text-gray-600 max-w-3xl leading-relaxed mb-6">
            {{ $module->description }}
        </p>

        <div class="flex flex-wrap items-center gap-6 text-xs text-gray-500 font-medium">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-book-open text-padma-primary" aria-hidden="true"></i> {{ $module->lesson_count }} Pelajaran Interaktif</span>
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-clock text-padma-secondary" aria-hidden="true"></i> Estimasi {{ $module->duration_minutes }} Menit</span>
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-trophy text-amber-500" aria-hidden="true"></i> Sertifikat Penyelesaian Padmasari</span>
        </div>
    </div>

    <!-- Curriculum Syllabus & Lesson Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Lesson List Syllabus -->
        <div class="lg:col-span-4 space-y-4">
            <h2 class="text-base font-bold font-serif text-gray-900 mb-3">Daftar Pelajaran Modul</h2>

            <div class="bg-white rounded-3xl border border-[#e9e4e1] divide-y divide-gray-100 overflow-hidden shadow-xs">
                <div class="p-4 bg-indigo-50/80 border-l-4 border-padma-primary flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-padma-primary">Pelajaran 1 (Aktif)</span>
                        <h3 class="text-xs font-bold text-gray-900 mt-0.5">Pengenalan Visual Aksara Swara &amp; Ngalagena</h3>
                    </div>
                    <i class="fa-solid fa-circle-play text-padma-primary text-base" aria-hidden="true"></i>
                </div>

                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between text-gray-400">
                    <div>
                        <span class="text-[10px] font-semibold uppercase text-gray-400">Pelajaran 2</span>
                        <h3 class="text-xs font-medium text-gray-700 mt-0.5">Vokalisasi (Rarangken) &amp; Konsonan Pasangan</h3>
                    </div>
                    <i class="fa-solid fa-lock text-xs" aria-hidden="true"></i>
                </div>

                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between text-gray-400">
                    <div>
                        <span class="text-[10px] font-semibold uppercase text-gray-400">Pelajaran 3</span>
                        <h3 class="text-xs font-medium text-gray-700 mt-0.5">Identifikasi Fragmentasi Lontar dengan AI Vision</h3>
                    </div>
                    <i class="fa-solid fa-lock text-xs" aria-hidden="true"></i>
                </div>

                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between text-gray-400">
                    <div>
                        <span class="text-[10px] font-semibold uppercase text-gray-400">Pelajaran 4</span>
                        <h3 class="text-xs font-medium text-gray-700 mt-0.5">Kuis Evaluasi &amp; Latihan Transkripsi Mandiri</h3>
                    </div>
                    <i class="fa-solid fa-lock text-xs" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <!-- Main Interactive Content Box -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-[#e9e4e1] p-6 sm:p-8 shadow-xs">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                <span class="px-3 py-1 bg-amber-100 text-amber-900 text-xs font-bold rounded-md">Pelajaran 1 dari {{ $module->lesson_count }}</span>
                <span class="text-xs text-gray-500 font-medium">Kuis &amp; Interaktif Available</span>
            </div>

            <h2 class="text-2xl font-bold font-serif text-gray-900 mb-4">Pengenalan Visual Aksara Swara &amp; Ngalagena</h2>

            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed space-y-4 font-sans mb-8">
                <p>
                    Aksara Sunda Kuno (Sunda Kawi) digunakan pada prasasti dan naskah lontar abad ke-14 hingga ke-16 Masehi di wilayah Kerajaan Sunda. Aksara ini secara umum terbagi menjadi dua kelompok utama:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-6">
                    <div class="p-5 bg-amber-50/80 rounded-2xl border border-amber-200/80">
                        <h3 class="font-bold text-xs uppercase text-amber-900 mb-1">1. Aksara Swara (Vokal Mandiri)</h3>
                        <p class="text-xs text-amber-950">Terdiri dari vokal murni: a, i, u, e, o, e (pepet), eu.</p>
                    </div>

                    <div class="p-5 bg-indigo-50/80 rounded-2xl border border-indigo-200/80">
                        <h3 class="font-bold text-xs uppercase text-indigo-900 mb-1">2. Aksara Ngalagena (Konsonan)</h3>
                        <p class="text-xs text-indigo-950">Terdiri dari 18 konsonan dasar yang masing-masing mengandung vokal inherent '/a/'.</p>
                    </div>
                </div>

                <p>
                    Dalam teknologi <strong>Padmasari AI Vision</strong>, setiap karakter dibaca menggunakan bobot Convolutional Neural Network yang dilatih khusus pada ribuan spesimen daun lontar ter-digitalisasi dari Perpustakaan Nasional RI dan museum lokal.
                </p>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-between gap-4">
                <span class="text-xs font-bold text-emerald-700 flex items-center gap-1.5"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Modul Interaktif Padmasari Validated</span>
                <a href="#" onclick="alert('Selamat! Anda telah menyelesaikan Pelajaran 1.'); location.href='{{ route('dashboard') }}';" class="tactile-btn px-6 py-3 bg-padma-primary hover:bg-padma-primary-hover text-white font-bold text-xs sm:text-sm rounded-2xl shadow-xs transition-all flex items-center gap-2">
                    Selesaikan Pelajaran Ini &rarr;
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

