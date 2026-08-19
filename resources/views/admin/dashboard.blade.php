@extends('layouts.app')

@section('title', 'Admin Dashboard - Padmasari AI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Admin Header Banner -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 mb-8 border border-white shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-padma-primary text-white flex items-center justify-center text-2xl font-bold font-serif shadow-md">
                <i class="fa-solid fa-user-gear"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold font-serif text-gray-900">Panel Kontrol Admin</h1>
                    <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Mode Admin Active</span>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Proyek Supabase: <code class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded text-xs">novel</code> ({{ $supabaseUrl }})
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-red-50 text-red-700 hover:bg-red-100 text-sm font-semibold rounded-xl border border-red-200 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout Admin
                </button>
            </form>
        </div>
    </div>

    <!-- Master Narrative Lock Configuration Panel -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-[#e9e4e1] shadow-xs mb-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-900 text-xs font-bold uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-lock text-amber-600"></i> Core Baseline Topic Lock
                </span>
                <h2 class="text-xl font-bold font-serif text-gray-900">Pengaturan Narasi Master (Acuan AI Filologi)</h2>
                <p class="text-xs text-gray-500 mt-1">Konfigurasi topik utama &amp; instruksi dasar yang dikunci untuk seluruh generasi cerita AI baru.</p>
            </div>
            <div class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold flex items-center gap-1.5 self-start md:self-auto">
                <i class="fa-solid fa-cloud-check text-emerald-600"></i> Terhubung Supabase DB
            </div>
        </div>

        <form action="{{ route('admin.master-narrative.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Judul Kerangka Master</label>
                    <input type="text" name="title" value="{{ $masterNarrative->title }}" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm font-semibold outline-none transition-all bg-gray-50/50 focus:bg-white text-gray-900" required>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Topik / Tema Acuan (Locked Topic)</label>
                    <input type="text" name="core_topic" value="{{ $masterNarrative->core_topic }}" class="w-full px-4 py-3 rounded-2xl border border-amber-300 bg-amber-50/50 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm font-bold text-amber-950 outline-none transition-all" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                    <i class="fa-solid fa-scroll text-padma-primary"></i> Naskah Cerita Master Terkunci (Base Master Text) <span class="text-red-500">*</span>
                </label>
                <p class="text-[11px] text-gray-500 mb-2">Teks naskah utuh yang menjadi acuan utama AI. Seluruh cerita baru yang di-generate akan bersumber dan diadaptasi dari naskah ini.</p>
                <textarea name="master_content" rows="6" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm outline-none transition-all bg-gray-50/50 focus:bg-white text-gray-900 resize-y leading-relaxed font-serif" placeholder="Tempel naskah cerita master lengkap di sini..." required>{{ $masterNarrative->master_content }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Ringkasan Naskah Master</label>
                <input type="text" name="core_summary" value="{{ $masterNarrative->core_summary }}" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm outline-none transition-all bg-gray-50/50 focus:bg-white text-gray-900">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Aturan Dunia &amp; Batasan Filologi (World Rules)</label>
                <textarea name="world_rules" rows="2" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm outline-none transition-all bg-gray-50/50 focus:bg-white text-gray-900 resize-none leading-relaxed" required>{{ $masterNarrative->world_rules }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">System Instruction AI (Prompt Dasar Engine)</label>
                <textarea name="system_prompt" rows="2" class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 text-xs sm:text-sm outline-none transition-all bg-gray-50/50 focus:bg-white text-gray-900 resize-none leading-relaxed" required>{{ $masterNarrative->system_prompt }}</textarea>
            </div>


            <div class="flex justify-end">
                <button type="submit" class="tactile-btn px-6 py-3 bg-padma-primary hover:bg-padma-primary-hover text-white text-xs font-bold rounded-2xl shadow-xs transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan &amp; Perbarui Narasi Master
                </button>
            </div>
        </form>
    </div>

    <!-- Quick System Stats -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-padma-primary flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div>
                <span class="text-2xl font-extrabold font-serif text-gray-900 block">{{ $stories->count() }}</span>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Cerita Dipublikasi</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-padma-secondary flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <span class="text-2xl font-extrabold font-serif text-gray-900 block">{{ $modules->count() }}</span>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Modul Pembelajaran</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-database"></i>
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block">Supabase Connected</span>
                <span class="text-xs text-gray-500">Project: novel</span>
            </div>
        </div>
    </div>

    <!-- Management Forms Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
        
        <!-- Create New Story Form -->
        <div class="lg:col-span-6 bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold font-serif text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                <i class="fa-solid fa-plus-circle text-padma-primary"></i> Publikasi Cerita AI Baru (Admin)
            </h3>

            <form action="{{ route('admin.stories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Judul Cerita</label>
                    <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" placeholder="Contoh: Petuah Resi Jayagiri di Tepian Citarum" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Tema Sastra</label>
                        <select name="theme" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-700 bg-white">
                            <option value="Wawacan & Legend">Wawacan & Legenda</option>
                            <option value="Sejarah & Filologi">Sejarah Kuno</option>
                            <option value="Hikmah & Moral">Hikmah & Moral</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Target Pembaca</label>
                        <select name="target_audience" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-700 bg-white">
                            <option value="Remaja & Mahasiswa">Remaja & Mahasiswa</option>
                            <option value="Anak-Anak">Anak-Anak</option>
                            <option value="Umum & Peneliti">Umum & Peneliti</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Pesan Moral</label>
                    <input type="text" name="moral_lesson" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" placeholder="Pesan filosofis cerita...">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Isi Cerita Lengkap</label>
                    <textarea name="content" rows="5" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none resize-none" placeholder="Tuliskan naskah cerita lengkap di sini..." required></textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" class="rounded text-padma-primary">
                    <label for="is_featured" class="text-xs font-semibold text-gray-700">Tampilkan di Beranda (Featured)</label>
                </div>

                <button type="submit" class="w-full py-3 bg-padma-primary hover:bg-indigo-900 text-white font-bold text-xs rounded-xl shadow transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Publikasikan Cerita
                </button>
            </form>
        </div>

        <!-- Create New Learning Module Form -->
        <div class="lg:col-span-6 bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold font-serif text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                <i class="fa-solid fa-graduation-cap text-padma-secondary"></i> Buat Modul Pembelajaran Baru (Admin)
            </h3>

            <form action="{{ route('admin.modules.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Judul Modul</label>
                    <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none" placeholder="Contoh: Analisis Pupuh Sinom & Asmarandana" required>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Kategori</label>
                        <input type="text" name="category" class="w-full px-4 py-2 rounded-xl border border-gray-200 text-xs focus:border-padma-primary outline-none" placeholder="Contoh: Sastra Klasik" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Tingkat Kesulitan</label>
                        <select name="difficulty" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-700 bg-white">
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Mahir">Mahir</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Jumlah Pelajaran</label>
                        <input type="number" name="lesson_count" value="5" min="1" class="w-full px-4 py-2 rounded-xl border border-gray-200 text-xs focus:border-padma-primary outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Durasi (Menit)</label>
                        <input type="number" name="duration_minutes" value="45" min="1" class="w-full px-4 py-2 rounded-xl border border-gray-200 text-xs focus:border-padma-primary outline-none" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Deskripsi Modul</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary outline-none resize-none" placeholder="Ringkasan isi modul..." required></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-padma-secondary hover:bg-amber-900 text-white font-bold text-xs rounded-xl shadow transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-folder-plus"></i> Publikasikan Modul
                </button>
            </form>
        </div>

    </div>

    <!-- Management Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Manage Stories List -->
        <div class="lg:col-span-6 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="text-base font-bold font-serif text-gray-900 mb-4">Daftar Cerita Dipublikasi</h3>
            <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @foreach($stories as $st)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase text-padma-secondary">{{ $st->theme }}</span>
                            <h4 class="text-xs font-bold text-gray-900">{{ $st->title }}</h4>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.stories.edit', $st->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold rounded-lg border border-amber-200 transition-colors flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                            </a>
                            <form action="{{ route('admin.stories.destroy', $st->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus cerita ini?')" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-lg border border-red-200 transition-colors flex items-center gap-1">
                                    <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Manage Modules List -->
        <div class="lg:col-span-6 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <h3 class="text-base font-bold font-serif text-gray-900 mb-4">Daftar Modul Pembelajaran</h3>
            <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @foreach($modules as $md)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase text-padma-primary">{{ $md->category }}</span>
                            <h4 class="text-xs font-bold text-gray-900">{{ $md->title }}</h4>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.modules.edit', $md->id) }}" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-padma-primary text-xs font-bold rounded-lg border border-indigo-200 transition-colors flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                            </a>
                            <form action="{{ route('admin.modules.destroy', $md->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus modul ini?')" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold rounded-lg border border-red-200 transition-colors flex items-center gap-1">
                                    <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
