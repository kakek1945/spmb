<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - {{ config('spmb.app_name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    @include('partials.vite-assets')
</head>
<body class="theme-admin min-h-screen text-slate-900">
    <div class="h-1.5 bg-gradient-to-r from-[#103b73] via-[#0f766e] to-[#b58b3b]"></div>
    <main class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid w-full gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <section class="section-shell border-t-4 border-t-[#103b73]">
                <div class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/70">
                        <img src="{{ config('spmb.school.logo_url') }}" alt="Logo {{ config('spmb.school.name') }}" class="h-9 w-9 object-contain" referrerpolicy="no-referrer">
                    </span>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#0b5cab]">Portal Administrator</p>
                        <p class="mt-1 text-sm font-semibold text-slate-700">{{ config('spmb.school.name') }}</p>
                    </div>
                </div>
                <h1 class="font-display mt-5 text-4xl font-semibold tracking-tight text-[#10233d]">Masuk ke dashboard.</h1>
                <p class="mt-3 max-w-sm text-sm leading-7 text-slate-600">Kelola pendaftar, kuota jalur, dan laporan sekolah dari satu panel yang rapi dan mudah dipantau.</p>
                <div class="mt-8 grid gap-3 text-sm text-slate-700">
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3 shadow-sm shadow-slate-200/40">
                        <x-heroicon-o-chart-bar class="h-5 w-5 text-[#0b5cab]" />
                        <span>Statistik pendaftaran</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3 shadow-sm shadow-slate-200/40">
                        <x-heroicon-o-users class="h-5 w-5 text-[#0b5cab]" />
                        <span>Data calon siswa</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3 shadow-sm shadow-slate-200/40">
                        <x-heroicon-o-clipboard-document-list class="h-5 w-5 text-[#0b5cab]" />
                        <span>Kapasitas per jalur</span>
                    </div>
                </div>
            </section>

            <section class="section-shell">
                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#0b5cab]">Login</p>
                <h2 class="mt-3 text-3xl font-semibold text-slate-950">Masuk sebagai admin</h2>
                <p class="mt-2 text-sm leading-7 text-slate-600">Gunakan akun administrator untuk mengakses panel pengelolaan SPMB sekolah.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label class="form-label">Email admin</label>
                        <div class="relative mt-2">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <x-heroicon-o-users class="h-5 w-5" />
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input pl-12" placeholder="Masukkan email admin" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Password</label>
                        <div class="relative mt-2">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <x-heroicon-o-key class="h-5 w-5" />
                            </span>
                            <input type="password" name="password" class="form-input pl-12" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-hero-primary w-full rounded-2xl py-3.5">
                        <x-heroicon-o-arrow-right-end-on-rectangle class="h-5 w-5" />
                        <span>Masuk ke Dashboard</span>
                    </button>
                </form>
            </section>
        </div>
    </main>

    <div data-toast-root class="pointer-events-none fixed inset-x-0 top-5 z-50 hidden justify-center px-4">
        <div data-toast class="rounded-full bg-slate-950 px-5 py-3 text-sm font-medium text-white shadow-2xl shadow-slate-900/20"></div>
    </div>
</body>
</html>
