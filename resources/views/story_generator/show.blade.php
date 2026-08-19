@extends('layouts.app')

@section('title', $story->title . ' - Padmasari AI Story')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">

    <!-- Back Navigation -->
    <a href="{{ route('story-generator.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-padma-primary hover:text-padma-primary-hover mb-8 transition-colors">
        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i> Kembali ke Generator Cerita
    </a>

    <!-- Main Story Article -->
    <article class="bg-white rounded-3xl border border-[#e9e4e1] shadow-xs p-6 sm:p-12 mb-12">
        
        <!-- Header Metadata -->
        <header class="mb-8 pb-8 border-b border-gray-100">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-amber-100 text-amber-900 text-[11px] font-bold rounded-full uppercase tracking-wider">
                    {{ $story->theme }}
                </span>
                <span class="px-3 py-1 bg-indigo-50 text-padma-primary text-[11px] font-bold rounded-full">
                    Target: {{ $story->target_audience }}
                </span>
                <span class="text-xs text-gray-400 font-medium ml-auto flex items-center gap-1">
                    <i class="fa-solid fa-eye text-gray-400" aria-hidden="true"></i> {{ $story->reads_count }} Dibaca
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif text-gray-900 leading-tight mb-4 tracking-tight">
                {{ $story->title }}
            </h1>

            <p class="text-xs text-gray-500 font-sans">
                Diproses oleh <strong class="text-gray-700">Padmasari AI Engine</strong> &bull; {{ $story->created_at->format('d M Y, H:i') }}
            </p>
        </header>

        <!-- Moral Lesson Highlight Callout Box -->
        @if($story->moral_lesson)
            <div class="bg-amber-50/90 border-l-4 border-amber-500 rounded-r-2xl p-5 mb-8 text-amber-900 text-sm">
                <div class="font-bold text-xs uppercase tracking-wider text-amber-800 mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-quote-left text-amber-600" aria-hidden="true"></i> Pesan Moral &amp; Filosofi
                </div>
                <p class="font-serif italic text-base sm:text-lg">"{{ $story->moral_lesson }}"</p>
            </div>
        @endif

        <!-- Story Content Body -->
        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed font-sans space-y-6 text-sm sm:text-base">
            {!! nl2br(e($story->content)) !!}
        </div>

        <!-- Article Action Buttons -->
        <footer class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button onclick="navigator.clipboard.writeText(`{{ addslashes($story->content) }}`); alert('Teks cerita berhasil disalin!')" class="tactile-btn px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                    <i class="fa-regular fa-copy" aria-hidden="true"></i> Salin Teks
                </button>
                <a href="data:text/plain;charset=utf-8,{{ urlencode($story->content) }}" download="{{ Str::slug($story->title) }}.txt" class="tactile-btn px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                    <i class="fa-solid fa-download" aria-hidden="true"></i> Unduh .TXT
                </a>
            </div>

            <a href="{{ route('story-generator.index') }}" class="tactile-btn px-5 py-2.5 bg-padma-primary hover:bg-padma-primary-hover text-white text-xs font-bold rounded-xl transition-all flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-wand-magic-sparkles text-amber-300" aria-hidden="true"></i> Generate Cerita Lainnya
            </a>
        </footer>

    </article>

    <!-- Related Stories -->
    @if($relatedStories->count() > 0)
        <div>
            <h2 class="text-xl font-bold font-serif text-gray-900 mb-6">Cerita Terkait Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedStories as $rel)
                    <div class="bg-white p-5 rounded-3xl border border-[#e9e4e1] shadow-xs hover:shadow-md transition-all">
                        <span class="text-[10px] font-bold text-padma-secondary uppercase tracking-wider bg-amber-50 px-2 py-0.5 rounded">{{ $rel->theme }}</span>
                        <h3 class="text-base font-bold font-serif text-gray-900 mt-2 mb-2">
                            <a href="{{ route('story-generator.show', $rel->id) }}" class="hover:text-padma-primary transition-colors">
                                {{ $rel->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ Str::limit($rel->content, 100) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection


