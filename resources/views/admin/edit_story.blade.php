@extends('layouts.app')

@section('title', 'Edit Cerita Publikasi - Admin Padmasari AI')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-padma-primary hover:underline mb-6">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard Admin
    </a>

    <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-sm">
        <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-padma-primary"></i> Edit Cerita Publikasi
        </h1>

        <form action="{{ route('admin.stories.update', $story->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Judul Cerita</label>
                <input type="text" name="title" value="{{ old('title', $story->title) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Tema Sastra</label>
                    <select name="theme" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 bg-white">
                        <option value="Wawacan & Legend" {{ $story->theme == 'Wawacan & Legend' ? 'selected' : '' }}>Wawacan & Legenda</option>
                        <option value="Sejarah & Filologi" {{ $story->theme == 'Sejarah & Filologi' ? 'selected' : '' }}>Sejarah Kuno</option>
                        <option value="Hikmah & Moral" {{ $story->theme == 'Hikmah & Moral' ? 'selected' : '' }}>Hikmah & Moral</option>
                        <option value="Mitos & Kosmologi" {{ $story->theme == 'Mitos & Kosmologi' ? 'selected' : '' }}>Mitos & Kosmologi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Target Pembaca</label>
                    <select name="target_audience" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 bg-white">
                        <option value="Remaja & Mahasiswa" {{ $story->target_audience == 'Remaja & Mahasiswa' ? 'selected' : '' }}>Remaja & Mahasiswa</option>
                        <option value="Anak-Anak" {{ $story->target_audience == 'Anak-Anak' ? 'selected' : '' }}>Anak-Anak</option>
                        <option value="Umum & Peneliti" {{ $story->target_audience == 'Umum & Peneliti' ? 'selected' : '' }}>Umum & Peneliti</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Pesan Moral & Filosofi</label>
                <input type="text" name="moral_lesson" value="{{ old('moral_lesson', $story->moral_lesson) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Isi Cerita Lengkap</label>
                <textarea name="content" rows="10" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none font-sans leading-relaxed resize-none" required>{{ old('content', $story->content) }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ $story->is_featured ? 'checked' : '' }} class="rounded text-padma-primary">
                <label for="is_featured" class="text-xs font-semibold text-gray-700">Tampilkan di Beranda (Featured)</label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-padma-primary hover:bg-indigo-900 text-white font-bold text-xs rounded-xl shadow transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan Cerita
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
