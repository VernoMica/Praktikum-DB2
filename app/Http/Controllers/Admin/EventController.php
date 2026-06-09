<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        // Memakai relasi dan pengaturan limit paginasi (10 entri per halaman)
        $events = \App\Models\Event::with('category')->latest()
            ->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'category_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'poster' => 'nullable|image|max:2048' // Maksimal 2MB
        ]);

        if ($request->hasFile('poster')) {
            // Simpan ke direktori storage/app/public/posters
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        // Menyimpan data yang telah divalidasi ke dalam tabel menggunakan Model
        \App\Models\Event::create($data);
        
        return redirect()->route('admin.events.index')->with('success','Data Event berhasil ditambahkan.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success','Data event berhasil dihapus secara permanen.');
    }

    public function edit(Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('admin.events.edit', compact('event','categories'));
    }

    public function update(\Illuminate\Http\Request $request, Event $event)
    {
        $data = $request->validate([
        'category_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'poster' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('poster')) {
            // Hapus gambar lama jika sebelumnya sudah memiliki poster
            if ($event->poster_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
            }
            // Upload gambar baru
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Rincian data event berhasil diperbarui.');
    }
}