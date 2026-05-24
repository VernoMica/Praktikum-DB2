<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('logo_url', 'LIKE', '%' . $request->search . '%');
        }

        $partners = $query->get();
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name',
            'logo_url' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama partner wajib diisi.',
            'name.string' => 'Nama partner harus berupa teks.',
            'name.max' => 'Nama partner tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama partner sudah terdaftar.',
            'logo_url.required' => 'URL logo wajib diisi.',
            'logo_url.string' => 'URL logo harus berupa teks.',
            'logo_url.max' => 'URL logo tidak boleh lebih dari 255 karakter.',
        ]);

        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name,' . $partner->id,
            'logo_url' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama partner wajib diisi.',
            'name.string' => 'Nama partner harus berupa teks.',
            'name.max' => 'Nama partner tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama partner sudah terdaftar.',
            'logo_url.required' => 'URL logo wajib diisi.',
            'logo_url.string' => 'URL logo harus berupa teks.',
            'logo_url.max' => 'URL logo tidak boleh lebih dari 255 karakter.',
        ]);

        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}
