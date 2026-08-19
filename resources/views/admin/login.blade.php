@extends('layouts.app')

@section('title', 'Login Admin - Padmasari AI')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">

    <div class="glass-card rounded-3xl p-8 border border-white shadow-xl">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-padma-primary to-padma-secondary text-white text-2xl flex items-center justify-center mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <h1 class="text-2xl font-bold font-serif text-gray-900">Portal Mode Admin</h1>
            <p class="text-xs text-gray-500 mt-1">Masuk untuk mengelola platform & konten Padmasari AI</p>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Email Admin</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                    <input type="email" name="email" value="{{ old('email', 'admin@padmasari.ai') }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 outline-none" required placeholder="admin@padmasari.ai">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Password Admin</label>
                <div class="relative">
                    <i class="fa-solid fa-key absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                    <input type="password" name="password" value="admin123" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:border-padma-primary focus:ring-2 focus:ring-indigo-100 outline-none" required placeholder="••••••••">
                </div>
            </div>

            <div class="bg-amber-50 p-3 rounded-xl border border-amber-200 text-xs text-amber-900 font-sans">
                <i class="fa-solid fa-lock text-amber-600 mr-1"></i> Mode Sistem: <strong>Admin Only Mode</strong> (Registrasi publik dinonaktifkan).
            </div>

            <button type="submit" class="w-full py-3.5 bg-padma-primary hover:bg-indigo-900 text-white font-bold text-sm rounded-xl shadow transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Ke Portal Admin
            </button>
        </form>

    </div>

</div>
@endsection
