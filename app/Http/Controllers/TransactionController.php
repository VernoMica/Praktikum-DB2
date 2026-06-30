<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('event')->latest();

        // 1. Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('customer_email', 'like', '%' . $search . '%');
            });
        }

        // 2. Status Filter
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        // 3. Date Filter (Bulan Ini, Bulan Lalu, Tahun 2024, Semua Waktu)
        $date = $request->input('date', 'Bulan Ini');
        if ($date === 'Bulan Ini') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($date === 'Bulan Lalu') {
            $query->whereMonth('created_at', now()->subMonth()->month)
                  ->whereYear('created_at', now()->subMonth()->year);
        } elseif ($date === 'Tahun 2024') {
            $query->whereYear('created_at', 2024);
        }


        // Mengambil transaksi terbaru dengan pembatasan 20 baris/halaman
        $transactions = $query->paginate(20)->withQueryString();

        return view('admin.transactions', compact('transactions'));
    }
}
