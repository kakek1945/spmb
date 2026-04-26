<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - '.config('spmb.app_name'))</title>
    <meta name="description" content="Dashboard admin prapendaftaran {{ config('spmb.school.name') }}.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    @include('partials.vite-assets')
</head>
<body class="theme-admin min-h-screen text-slate-900">
    <div class="min-h-screen lg:grid lg:grid-cols-[220px_1fr]">
        <aside class="dark-panel border-b border-white/6 text-slate-100 lg:min-h-screen lg:border-b-0 lg:border-r lg:border-slate-800/60">
            <div class="flex items-center justify-between px-4 py-4 lg:block">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="block text-white">
                        <span class="text-sm font-semibold uppercase tracking-[0.34em] text-slate-100">Administrator</span>
                    </a>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-200 lg:hidden">
                    <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />
                    <span>Publik</span>
                </a>
            </div>

            <nav class="grid gap-1.5 px-3 pb-4 lg:px-3">
                <a href="{{ route('admin.dashboard') }}" @class([
                    'admin-sidebar-link',
                    'admin-sidebar-link-active' => request()->routeIs('admin.dashboard'),
                    'admin-sidebar-link-idle' => ! request()->routeIs('admin.dashboard'),
                ])>
                    <x-heroicon-o-home class="h-4 w-4" />
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.registrants.index') }}" @class([
                    'admin-sidebar-link',
                    'admin-sidebar-link-active' => request()->routeIs('admin.registrants.*'),
                    'admin-sidebar-link-idle' => ! request()->routeIs('admin.registrants.*'),
                ])>
                    <x-heroicon-o-users class="h-4 w-4" />
                    <span>Data Pendaftar</span>
                </a>
                <a href="{{ route('admin.capacity') }}" @class([
                    'admin-sidebar-link',
                    'admin-sidebar-link-active' => request()->routeIs('admin.capacity'),
                    'admin-sidebar-link-idle' => ! request()->routeIs('admin.capacity'),
                ])>
                    <x-heroicon-o-chart-bar class="h-4 w-4" />
                    <span>Kapasitas Jalur</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" @class([
                    'admin-sidebar-link',
                    'admin-sidebar-link-active' => request()->routeIs('admin.reports.*'),
                    'admin-sidebar-link-idle' => ! request()->routeIs('admin.reports.*'),
                ])>
                    <x-heroicon-o-document-chart-bar class="h-4 w-4" />
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.password.edit') }}" @class([
                    'admin-sidebar-link',
                    'admin-sidebar-link-active' => request()->routeIs('admin.password.*'),
                    'admin-sidebar-link-idle' => ! request()->routeIs('admin.password.*'),
                ])>
                    <x-heroicon-o-key class="h-4 w-4" />
                    <span>Ubah Password</span>
                </a>
            </nav>

            <div class="px-3 pb-5">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-2xl border border-slate-800/80 bg-white/3 px-3 py-2.5 text-[13px] font-medium text-slate-300 transition hover:bg-slate-900 hover:text-white">
                        <x-heroicon-o-arrow-left-end-on-rectangle class="h-4 w-4" />
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-w-0">
            <header class="border-b border-slate-200 bg-white/95 backdrop-blur-xl">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-[#0b5cab]">@yield('eyebrow', 'Area Admin')</p>
                        <h1 class="mt-1 text-xl font-semibold text-[#10233d]">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="btn-hero-secondary hidden px-4 py-2 text-xs font-medium sm:inline-flex">
                            <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />
                            <span>Lihat Landing Page</span>
                        </a>
                        <span class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-700 shadow-sm shadow-slate-200/60">
                            <x-heroicon-o-building-library class="h-4 w-4" />
                            <span>Panel Administrator</span>
                        </span>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @if (session('login_message'))
                    <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                        {{ session('login_message') }}
                    </div>
                @endif

                @if (session('registrant_message'))
                    <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                        {{ session('registrant_message') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <div data-toast-root class="pointer-events-none fixed inset-x-0 top-5 z-50 hidden justify-center px-4">
        <div data-toast class="rounded-full bg-slate-950 px-5 py-3 text-sm font-medium text-white shadow-2xl shadow-slate-900/20"></div>
    </div>
</body>
</html>
