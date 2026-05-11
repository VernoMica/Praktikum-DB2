<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Category;

class EventController extends Controller
{
    /**
     * Display the specified event.
     */
    public function show($id)
    {
        // For now, focus only on rendering the view.
        return view('event-detail');
    }

    /**
     * Display the checkout page for the event.
     */
    public function checkout()
    {
        // For now, focus only on rendering the view.
        return view('checkout');
    }

    /**
     * Display the admin listing of events.
     */
    public function indexAdmin()
    {
        $events = Event::with('category')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
        ]);

        Event::create($request->all());

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
        ]);

        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}
