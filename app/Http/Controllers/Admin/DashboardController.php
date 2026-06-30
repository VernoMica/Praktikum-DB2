<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalRevenue    = Transaction::where('status', 'success')->sum('total_price');
        $totalTickets    = Transaction::where('status', 'success')->count();
        $totalEvents     = Event::where('date', '>=', now())->count();
        $pendingOrders   = Transaction::where('status', 'pending')->count();
        $latestTransactions = Transaction::with('event')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalTickets',
            'totalEvents',
            'pendingOrders',
            'latestTransactions'
        ));
    }
}
