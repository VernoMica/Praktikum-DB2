@extends('layouts.admin')

@section('content')

<div class="p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Form Tambah Partner</h2>
        <a href="{{ route('admin.partners.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.partners.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block mb-2 font-semibold text-gray-700">Nama Partner</label>
                <input type="text" name="name" 
                    class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                    placeholder="Masukkan nama perusahaan/organisasi partner"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">URL Logo Partner</label>
                <input type="url" name="logo_url" 
                    class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                    placeholder="Contoh: https://placehold.co/200x200"
                    required>
                <p class="text-xs text-gray-400 mt-2 italic">Gunakan URL gambar publik (png/jpg/svg)</p>
                @error('logo_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" 
                    class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all hover:-translate-y-0.5">
                    Simpan Partner Baru
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
