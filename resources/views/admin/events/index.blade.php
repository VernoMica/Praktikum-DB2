@extends('layouts.admin')

@section('header_left')
    <h1 class="text-3xl font-black">Kelola Event</h1>
    <p class="text-slate-500 font-medium">Buat dan atur acara seru Anda di sini.</p>
@endsection

@section('header_right')
    <a href="{{ route('admin.events.create') }}"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition text-sm flex items-center justify-center">
        + Tambah Event Baru
    </a>
@endsection

@section('content')

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3">
            <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm font-bold">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center gap-3">
            <svg class="w-6 h-6 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="text-sm font-bold">{{ session('error') }}</div>
        </div>
    @endif

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

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
    <div class="px-8 py-6 bg-slate-50/50 border-b">
        <form action="{{ route('admin.events.index') }}" method="GET" class="flex gap-4 items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event, lokasi, atau kategori..."
                class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm shadow-sm">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.events.index') }}" class="px-6 py-3 bg-slate-100 border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 active:scale-95 transition text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest border-b">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Kategori</th>
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4">Harga / Stok</th>
                    <th class="px-8 py-4">Lokasi</th>
                    <th class="px-8 py-4 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($events as $event)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $event->title }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold uppercase">{{ $event->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-8 py-6 text-slate-500 font-semibold text-sm">
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-400 font-medium">Stok: {{ $event->stock }}</p>
                    </td>
                    <td class="px-8 py-6 text-slate-500 font-semibold text-sm">
                        {{ $event->location }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.events.edit', $event->id) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition flex items-center justify-center"
                                title="Edit Event">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition flex items-center justify-center"
                                    title="Hapus Event">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-12 text-center text-slate-400 font-semibold">
                        Belum ada event yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection