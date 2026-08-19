@extends('layouts.app')

@section('title', 'Edit Modul Pembelajaran - Admin Padmasari AI')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-padma-primary hover:underline mb-6">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard Admin
    </a>

    <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-sm">
        <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-padma-secondary"></i> Edit Modul Pembelajaran
        </h1>

        <form action="{{ route('admin.modules.update', $module->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Judul Modul</label>
                <input type="text" name="title" value="{{ old('title', $module->title) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $module->category) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" required>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Tingkat Kesulitan</label>
                    <select name="difficulty" class="w-full px-3.5 py-3 rounded-xl border border-gray-200 text-sm text-gray-700 bg-white">
                        <option value="Pemula" {{ $module->difficulty == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                        <option value="Menengah" {{ $module->difficulty == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                        <option value="Mahir" {{ $module->difficulty == 'Mahir' ? 'selected' : '' }}>Mahir</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Jumlah Pelajaran</label>
                    <input type="number" name="lesson_count" value="{{ old('lesson_count', $module->lesson_count) }}" min="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" required>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Durasi (Menit)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $module->duration_minutes) }}" min="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" required>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Progres Siswa (%)</label>
                    <input type="number" name="progress_percent" value="{{ old('progress_percent', $module->progress_percent) }}" min="0" max="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Deskripsi Modul</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none resize-none" required>{{ old('description', $module->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-padma-secondary hover:bg-amber-900 text-white font-bold text-xs rounded-xl shadow transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan Modul
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
