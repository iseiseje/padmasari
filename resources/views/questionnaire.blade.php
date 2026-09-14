@extends('layouts.app')

@section('title', 'Kuesioner & Evaluasi - Padmasari AI')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Banner Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-10 relative overflow-hidden bg-gradient-to-br from-white via-slate-50 to-indigo-50/40 border border-slate-200/90 shadow-sm">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold font-mono tracking-wider border border-indigo-200/80">
                        <i class="fa-solid fa-clipboard-question text-indigo-600"></i> Kuesioner &amp; Feedback
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-display text-slate-950">
                        Formulir Evaluasi &amp; Umpan Balik
                    </h1>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        Masukan dan evaluasi Anda sangat berharga untuk pengembangan platform literatur dan pembelajaran manuskrip <strong>Padmasari AI</strong>. Silakan isi kuesioner di bawah ini.
                    </p>
                </div>

                <div class="shrink-0 flex flex-col sm:flex-row md:flex-col gap-3">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSdCjD5iiI-Gki3oSN46fxqm7V3wlsKZd5pgHGyO9VUSLu2nrA/viewform" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-up-right-from-square text-amber-400"></i> Buka di Tab Baru
                    </a>
                    <a href="{{ route('home') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-xs transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <!-- Google Form Embedded Container -->
        <div class="glass-card rounded-3xl p-2 sm:p-6 bg-white border border-slate-200/90 shadow-md overflow-hidden relative">
            <div class="w-full overflow-x-auto flex justify-center bg-slate-100/50 rounded-2xl p-1 sm:p-4">
                <iframe 
                    src="https://docs.google.com/forms/d/e/1FAIpQLSdCjD5iiI-Gki3oSN46fxqm7V3wlsKZd5pgHGyO9VUSLu2nrA/viewform?embedded=true" 
                    class="w-full max-w-3xl rounded-xl shadow-xs bg-white border border-slate-200/80 min-h-[850px] sm:min-h-[1000px] h-[75vh]" 
                    frameborder="0" 
                    marginheight="0" 
                    marginwidth="0">
                    Memuat formulir...
                </iframe>
            </div>
        </div>

    </div>
</div>
@endsection
