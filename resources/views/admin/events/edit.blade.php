@extends('layouts.admin')

@section('header_left')
    <h1 class="text-3xl font-black">Sunting Event</h1>
    <p class="text-slate-500 font-medium">Ubah detail dan pengaturan untuk event Anda.</p>
@endsection

@section('header_right')
    <a href="{{ route('admin.events.index') }}"
        class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 active:scale-95 transition text-sm flex items-center justify-center">
        Kembali ke Daftar
    </a>
@endsection

@section('content')
<div class="max-w-4xl mb-10">
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-start gap-3">
            <svg class="w-6 h-6 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <div class="text-sm font-bold mb-1">Gagal menyimpan data:</div>
                <ul class="list-disc list-inside text-xs font-semibold text-rose-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 md:p-10">
        <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Event</label>
                    <input type="text" name="title" id="title" value="{{ $event->title }}" required placeholder="Masukkan judul event"
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori Event</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800 bg-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-bold text-slate-700 mb-2">Lokasi / Gedung</label>
                        <input type="text" name="location" id="location" value="{{ $event->location }}" required placeholder="Masukkan lokasi"
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Pendek</label>
                    <textarea name="description" id="description" rows="4" required placeholder="Jelaskan mengenai event ini secara singkat..."
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">{{ $event->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Waktu</label>
                        <input type="datetime-local" name="date" id="date" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') }}" required
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800 bg-white">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-slate-700 mb-2">Harga Tiket (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ $event->price }}" min="0" required placeholder="Contoh: 75000"
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-bold text-slate-700 mb-2">Kapasitas Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ $event->stock }}" min="0" required placeholder="Contoh: 50"
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('admin.events.index') }}"
                        class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 active:scale-95 transition text-sm flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm shadow-lg shadow-indigo-100">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection