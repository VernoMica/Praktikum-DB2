@extends('layouts.admin')
@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')
@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">No</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">ID Order</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Nama Pengirim</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Email & No. HP</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Nominal Asli</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Total + Biaya Admin</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @forelse($transactions as $index => $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $transaction->order_id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $transaction->customer_name }}</td>
                        <td class="px-6 py-4 text-xs">
                            <div class="text-gray-900">{{ $transaction->customer_email }}</div>
                            <div class="text-gray-400">{{ $transaction->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">
                            Rp {{ number_format($transaction->total_price + 5000, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if(strtolower($transaction->status) == 'pending')
                                <span class="inline-flex items-center gap-1 rounded-full bg-yellow-50 px-2 py-1 text-xs font-semibold text-yellow-600">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-400">Belum ada data transaksi fiktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t items-center">
        {{ $transactions->links() }}
    </div>
</div>
@endsection