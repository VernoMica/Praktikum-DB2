@extends('layouts.admin')

@section('header_left')
    <h1 class="text-3xl font-black">Laporan Transaksi</h1>
    <p class="text-slate-500 font-medium">Pantau arus kas dan penjualan tiket Anda.</p>
@endsection

@section('header_right')
    <div class="flex gap-4">
        <button
            class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-white hover:border-indigo-600 hover:text-indigo-600 active:scale-95 transition text-sm">
            Ekspor Excel
        </button>
        <button
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition text-sm">
            Unduh PDF
        </button>
    </div>
@endsection

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-8 py-6 bg-slate-50/50 border-b">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex gap-4 items-center m-0">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Order ID, Nama, atau Email..."
                class="flex-1 px-5 py-3 rounded-2xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm">
            <select name="status" onchange="this.form.submit()"
                class="px-5 py-3 rounded-2xl border-slate-200 border bg-white outline-none text-sm font-bold">
                <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                <option class="text-green-600" value="Success" {{ request('status') == 'Success' ? 'selected' : '' }}>Success</option>
                <option class="text-orange-600" value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option class="text-rose-600" value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
            </select>
            <select name="date" onchange="this.form.submit()"
                class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold">
                <option value="Semua Waktu" {{ request('date') == 'Semua Waktu' ? 'selected' : '' }}>Semua Waktu</option>
                <option value="Bulan Ini" {{ request('date', 'Bulan Ini') == 'Bulan Ini' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="Bulan Lalu" {{ request('date') == 'Bulan Lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="Tahun 2024" {{ request('date') == 'Tahun 2024' ? 'selected' : '' }}>Tahun 2024</option>
            </select>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm shadow-md shadow-indigo-100">
                Cari
            </button>
            @if(request('search') || request('status') || (request('date') && request('date') !== 'Bulan Ini'))
                <a href="{{ route('admin.transactions.index') }}" class="px-6 py-3 bg-slate-100 border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 active:scale-95 transition text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Detail Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total Tagihan</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800">{{ $transaction->customer_name }}</p>
                        <p class="text-xs text-slate-500">{{ $transaction->customer_email }}</p>
                        @if($transaction->customer_phone)
                            <p class="text-[10px] text-slate-400 font-mono">{{ $transaction->customer_phone }}</p>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-medium text-slate-700">{{ $transaction->event->title ?? 'N/A' }}</p>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500">
                        {{ $transaction->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6">
                        @if(strtolower($transaction->status) == 'success')
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Success</span>
                        @elseif(strtolower($transaction->status) == 'pending')
                            <span
                                class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase ring-1 ring-orange-200">Pending</span>
                        @elseif(strtolower($transaction->status) == 'expired')
                            <span
                                class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200">Expired</span>
                        @else
                            <span
                                class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase ring-1 ring-slate-200">{{ $transaction->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right font-black text-slate-900">
                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-semibold">
                        Belum ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-slate-50/50 border-t flex justify-between items-center">
        <p class="text-sm text-slate-500 font-medium">
            Menampilkan {{ $transactions->count() > 0 ? $transactions->firstItem() : 0 }} sampai {{ $transactions->count() > 0 ? $transactions->lastItem() : 0 }} dari {{ $transactions->total() }} transaksi
        </p>
        <div class="flex gap-2">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection