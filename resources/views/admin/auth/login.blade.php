@extends('layouts.app')

@section('content')
<section class="min-h-screen flex items-center justify-center py-16">
    <div class="w-full max-w-6xl mx-auto px-6 grid gap-12 lg:grid-cols-[1.15fr_0.85fr] items-center">
        <div class="space-y-6">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm uppercase tracking-[0.25em]">
                Admin Portal
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">Masuk untuk Mengelola Event Amikom</h1>
            <p class="max-w-xl text-slate-500 text-lg leading-relaxed">Gunakan akun admin Amikom untuk mengakses dashboard, kelola event, partner, kategori, dan transaksi dalam satu platform.</p>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white/80 p-6 shadow-sm">
                    <h2 class="font-bold text-slate-900 mb-3">Keunggulan Admin</h2>
                    <ul class="space-y-3 text-slate-600 text-sm">
                        <li class="flex gap-3 items-start"><span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 font-semibold">✓</span> Akses cepat ke semua data event.</li>
                        <li class="flex gap-3 items-start"><span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 font-semibold">✓</span> Kontrol kategori dan partner resmi.</li>
                        <li class="flex gap-3 items-start"><span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 font-semibold">✓</span> Pantau transaksi dan laporan penjualan.</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white/80 p-6 shadow-sm">
                    <h2 class="font-bold text-slate-900 mb-3">Tips</h2>
                    <p class="text-slate-600 text-sm leading-relaxed">Pastikan email dan kata sandi admin sesuai data di sistem. Jika ada masalah, hubungi tim IT Amikom untuk verifikasi akun.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-2xl p-10">
            <div class="mb-8">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400 font-semibold">Login Admin</p>
                <h2 class="text-3xl font-black text-slate-900 mt-3">Masuk ke Dashboard</h2>
                <p class="text-slate-500 mt-2">Silakan masukkan kredensial admin Anda untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-rose-100 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="admin@amikom.ac.id">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Masukkan kata sandi">
                </div>

                <button type="submit" class="w-full rounded-3xl bg-indigo-600 px-5 py-4 text-sm font-semibold text-white shadow-xl shadow-indigo-200 transition hover:bg-indigo-700">Masuk Sekarang</button>
            </form>
        </div>
    </div>
</section>
@endsection
