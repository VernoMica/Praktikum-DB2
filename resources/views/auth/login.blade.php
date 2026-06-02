<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md bg-white shadow-xl rounded-3xl border border-slate-200 p-8">
        <h1 class="text-3xl font-semibold text-slate-900 text-center">Masuk ke Akun</h1>
        <p class="mt-3 text-sm text-slate-500 text-center">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>

        <form action="#" method="POST" class="mt-8 space-y-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700" for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    placeholder="email@contoh.com"
                    autocomplete="email"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                >
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700" for="password">Kata Sandi</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan kata sandi"
                    autocomplete="current-password"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200"
            >
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
