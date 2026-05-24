@extends('layouts.admin')

@section('header_left')
    <h1 class="text-3xl font-black">Kelola Partner</h1>
    <p class="text-slate-500 font-medium">Atur partner dan sponsor event Anda.</p>
@endsection

@section('header_right')
    <button
        onclick="openAddModal()"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition text-sm">
        + Tambah Partner
    </button>
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
    <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">
        <input type="text" id="search-input" placeholder="Cari partner..."
            class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="partner-table">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest border-b">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4 w-16">ID</th>
                    <th class="px-8 py-4 w-28">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">Logo URL</th>
                    <th class="px-8 py-4">Dibuat Pada</th>
                    <th class="px-8 py-4">Diupdate Pada</th>
                    <th class="px-8 py-4 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t" id="partner-table-body">
                @forelse($partners as $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-8 py-6 text-slate-500 font-bold">{{ $partner->id }}</td>
                    <td class="px-8 py-6">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm border flex items-center justify-center p-1 overflow-hidden">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-cover rounded-lg" onerror="this.src='https://placehold.co/200x200?text=No+Image';">
                        </div>
                    </td>
                    <td class="px-8 py-6 font-black text-slate-800">{{ $partner->name }}</td>
                    <td class="px-8 py-6 text-slate-500 font-medium text-xs break-all max-w-[200px]">{{ $partner->logo_url }}</td>
                    <td class="px-8 py-6 text-slate-400 text-sm font-semibold">{{ $partner->created_at ? $partner->created_at->format('d M Y, H:i') : '-' }}</td>
                    <td class="px-8 py-6 text-slate-400 text-sm font-semibold">{{ $partner->updated_at ? $partner->updated_at->format('d M Y, H:i') : '-' }}</td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <button
                                onclick="openEditModal({{ $partner->id }}, '{{ addslashes($partner->name) }}', '{{ addslashes($partner->logo_url) }}')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                title="Edit Partner">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                    title="Hapus Partner">
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
                    <td colspan="8" class="px-8 py-12 text-center text-slate-400 font-semibold">
                        Belum ada partner yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Partner -->
<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeAddModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
            <form action="{{ route('admin.partners.store') }}" method="POST">
                @csrf
                <div class="bg-white px-8 pt-8 pb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-slate-800" id="modal-title">Tambah Partner</h3>
                        <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                            <input type="text" name="name" id="name" required placeholder="Masukkan nama partner (contoh: Samsung)"
                                class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                        </div>
                        <div>
                            <label for="logo_url" class="block text-sm font-bold text-slate-700 mb-2">URL Logo Partner</label>
                            <input type="text" name="logo_url" id="logo_url" required placeholder="Masukkan URL logo partner (contoh: https://...)"
                                class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50/50 px-8 py-5 flex flex-row-reverse gap-3 border-t">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm">
                        Simpan Partner
                    </button>
                    <button type="button" onclick="closeAddModal()" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 active:scale-95 transition text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Partner -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-8 pt-8 pb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-slate-800" id="modal-title">Edit Partner</h3>
                        <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="edit_name" class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                            <input type="text" name="name" id="edit_name" required placeholder="Masukkan nama partner"
                                class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                        </div>
                        <div>
                            <label for="edit_logo_url" class="block text-sm font-bold text-slate-700 mb-2">URL Logo Partner</label>
                            <input type="text" name="logo_url" id="edit_logo_url" required placeholder="Masukkan URL logo partner"
                                class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-800">
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50/50 px-8 py-5 flex flex-row-reverse gap-3 border-t">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition text-sm">
                        Perbarui Partner
                    </button>
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 active:scale-95 transition text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('name').value = '';
        document.getElementById('logo_url').value = '';
        document.getElementById('name').focus();
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(id, name, logoUrl) {
        const form = document.getElementById('editForm');
        let url = "{{ route('admin.partners.update', ':id') }}";
        url = url.replace(':id', id);
        form.action = url;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_logo_url').value = logoUrl;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('edit_name').focus();
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Live search partners
    document.getElementById('search-input').addEventListener('keyup', function(e) {
        let query = e.target.value.toLowerCase();
        let rows = document.querySelectorAll('#partner-table-body tr');
        rows.forEach(row => {
            if (row.cells.length < 2) return;
            let id = row.cells[1].textContent.toLowerCase();
            let name = row.cells[3].textContent.toLowerCase();
            let logoUrl = row.cells[4].textContent.toLowerCase();
            if (id.includes(query) || name.includes(query) || logoUrl.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
