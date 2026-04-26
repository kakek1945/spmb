<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('spmb.app_name'))</title>
    <meta name="description" content="{{ config('spmb.tagline') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    @include('partials.vite-assets')
</head>
<body class="theme-public min-h-screen relative text-slate-900 antialiased selection:bg-teal-200 selection:text-teal-900">
    <div class="pointer-events-none fixed inset-0 z-[-1] overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#103b73] via-[#0f766e] to-[#b58b3b]"></div>
    </div>
    <div class="min-h-screen flex flex-col">
        <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white ring-1 ring-slate-200 shadow-sm shadow-slate-200/70">
                        <img src="{{ config('spmb.school.logo_url') }}" alt="Logo {{ config('spmb.school.name') }}" class="h-9 w-9 object-contain" referrerpolicy="no-referrer">
                    </span>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.34em] text-[#0f766e]">SPMB</p>
                        <p class="font-display text-lg font-bold tracking-tight text-[#10233d]">{{ config('spmb.school.name') }}</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                    <a href="{{ route('admin.login') }}" class="btn-hero-secondary px-4 py-2 text-sm">
                        <x-heroicon-o-lock-closed class="h-4 w-4" />
                        <span>Masuk Admin</span>
                    </a>
                </nav>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-auto border-t border-slate-200 bg-white/95 backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="grid gap-6 text-sm text-slate-600 sm:grid-cols-2 lg:grid-cols-[220px_1fr]">
                    <div>
                        <div class="font-semibold text-slate-900">{{ config('spmb.school.name') }}</div>
                        <div class="mt-2 leading-relaxed">{{ config('spmb.school.info') }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-slate-900">Alamat</div>
                        <div class="mt-2 leading-relaxed">{{ config('spmb.school.address') }}</div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div data-toast-root class="pointer-events-none fixed inset-x-0 top-5 z-50 hidden justify-center px-4">
        <div data-toast class="rounded-full bg-slate-950 px-5 py-3 text-sm font-medium text-white shadow-2xl shadow-slate-900/20"></div>
    </div>
</body>
</html>
