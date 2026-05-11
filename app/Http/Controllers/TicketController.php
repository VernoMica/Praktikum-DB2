<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the specified ticket.
     */
    public function show($id)
    {
        // For now, focus only on rendering the view.
        return view('ticket');
    }
}
