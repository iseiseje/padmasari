@extends('layouts.app')

@section('title', 'Dashboard Siswa - Padmasari AI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight">Dashboard &amp; Portal Dokumen Statis</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan akses manuskrip kuno Padmasari</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('documents.novel') }}" class="tactile-btn px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-2xl transition-all flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-book" aria-hidden="true"></i> Novel
            </a>
            <a href="{{ route('documents.naskah') }}" class="tactile-btn px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-2xl transition-all flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-scroll" aria-hidden="true"></i> Naskah
            </a>
            <a href="{{ route('documents.drama') }}" class="tactile-btn px-4 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-bold rounded-2xl transition-all flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-masks-theater" aria-hidden="true"></i> Drama
            </a>
        </div>
    </div>

    <!-- Quick Access Document Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <a href="{{ route('documents.novel') }}" class="group bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs hover:border-amber-500/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-4 font-bold group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-book" aria-hidden="true"></i>
            </div>
            <h3 class="text-lg font-bold font-serif text-gray-900 group-hover:text-amber-600 transition-colors">PADMASARI BENTUK NOVEL</h3>
            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Dokumen naratif novel lengkap karya Prof. Burhan Nurgiyantoro.</p>
        </a>

        <a href="{{ route('documents.naskah') }}" class="group bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs hover:border-emerald-500/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4 font-bold group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-scroll" aria-hidden="true"></i>
            </div>
            <h3 class="text-lg font-bold font-serif text-gray-900 group-hover:text-emerald-600 transition-colors">NASKAH CERITA</h3>
            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Adaptasi naskah cerita terstruktur untuk analisis filologi.</p>
        </a>

        <a href="{{ route('documents.drama') }}" class="group bg-white p-6 rounded-3xl border border-[#e9e4e1] shadow-xs hover:border-cyan-500/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl mb-4 font-bold group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-masks-theater" aria-hidden="true"></i>
            </div>
            <h3 class="text-lg font-bold font-serif text-gray-900 group-hover:text-cyan-600 transition-colors">NASKAH DRAMA</h3>
            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Naskah pementasan teater dengan dialog antarkarakter.</p>
        </a>
    </div>

</div>
@endsection

