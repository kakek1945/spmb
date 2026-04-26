@extends('layouts.public')

@section('title', config('spmb.app_name').' - Landing Page')

@section('content')
    <section class="mx-auto grid max-w-7xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[1.08fr_0.92fr] lg:px-8 lg:py-16">
        <div class="flex flex-col items-start">
            <span class="eyebrow-badge border-slate-200 bg-white px-3 py-1.5 text-[10px] tracking-[0.2em] text-[#0b5cab] shadow-sm sm:px-4 sm:py-2 sm:text-xs">
                <span>Prapendaftaran Murid Baru 2026</span>
            </span>
            <h1 class="font-display mt-6 max-w-4xl text-4xl tracking-tight text-slate-950 sm:text-5xl lg:text-6xl flex flex-col gap-1 sm:gap-2">
                <span class="font-black text-[#10233d]">SPMB Pra Pendaftaran</span>
                <span class="font-bold text-2xl sm:text-4xl text-[#183b66]">SMP Negeri 1 Merbau</span>
                <span class="font-medium text-xl sm:text-3xl text-slate-500">Tahun Ajaran 2026-2027</span>
            </h1>
            <p class="mt-4 max-w-2xl text-sm sm:text-base leading-7 text-slate-600">Pilih jalur pendaftaran yang sesuai, isi data dengan lengkap, lalu simpan nomor pendaftaran untuk proses berikutnya.</p>

            <div class="mt-8 flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                <a href="{{ route('registration.create') }}" class="btn-hero-primary group w-full py-3.5 sm:w-auto sm:py-3">
                    <x-heroicon-o-pencil-square class="h-5 w-5" />
                    <span>Daftar Sekarang</span>
                </a>
                <a href="#jalur" class="btn-hero-secondary w-full py-3.5 sm:w-auto sm:py-3">
                    <x-heroicon-o-squares-2x2 class="h-5 w-5 opacity-70" />
                    <span>Lihat Informasi Jalur</span>
                </a>
            </div>

            <dl class="mt-10 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-3">
                <div class="metric-card col-span-2 lg:col-span-1 transition-transform hover:-translate-y-1">
                    <dt class="inline-flex items-center gap-1.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">
                        <x-heroicon-o-users class="h-4 w-4 text-indigo-500" />
                        <span>Total Pendaftar</span>
                    </dt>
                    <dd class="mt-2 sm:mt-3 text-2xl sm:text-3xl font-bold text-slate-950">{{ $stats['total_registrations'] }}</dd>
                </div>
                <div class="metric-card transition-transform hover:-translate-y-1">
                    <dt class="inline-flex items-center gap-1.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">
                        <x-heroicon-o-chart-bar class="h-4 w-4 text-blue-500" />
                        <span>Kapasitas Total</span>
                    </dt>
                    <dd class="mt-2 sm:mt-3 text-2xl sm:text-3xl font-bold text-slate-950">{{ $stats['total_capacity'] }}</dd>
                </div>
                <div class="metric-card transition-transform hover:-translate-y-1">
                    <dt class="inline-flex items-center gap-1.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">
                        <x-heroicon-o-clipboard-document-list class="h-4 w-4 text-teal-500" />
                        <span>Sisa Kapasitas</span>
                    </dt>
                    <dd class="mt-2 sm:mt-3 text-2xl sm:text-3xl font-bold text-slate-950">{{ $stats['remaining_capacity'] }}</dd>
                </div>
            </dl>
        </div>

        <div class="section-shell border-t-4 border-t-[#103b73] p-5 sm:p-8 text-slate-900">
            <div class="flex items-start sm:items-center justify-between gap-4 flex-col sm:flex-row">
                <div>
                    <p class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#0b5cab]">
                        <x-heroicon-o-document-text class="h-4 w-4" />
                        <span>Ringkasan Pendaftar</span>
                    </p>
                    <h2 class="mt-2 font-display text-2xl sm:text-3xl font-bold text-[#10233d]">Pendaftar terbaru</h2>
                </div>
                <a href="{{ route('admin.login') }}" class="btn-hero-secondary px-4 py-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest">
                    <x-heroicon-o-lock-closed class="h-4 w-4" />
                    <span>Admin</span>
                </a>
            </div>

            <div class="mt-6 sm:mt-8 grid gap-3 sm:gap-4">
                @forelse ($recentRegistrations as $registration)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $registration['full_name'] }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.24em] text-slate-500">{{ $registration['registration_number'] }}</p>
                            </div>
                            @include('partials.path-badge', ['code' => $registration['path_code']])
                        </div>
                        <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-building-office-2 class="h-4 w-4" />
                                <span>{{ $registration['previous_school'] }}</span>
                            </span>
                            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-calendar-days class="h-4 w-4" />
                                <span>{{ $registration['submitted_at_human'] }}</span>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">
                        Belum ada data pendaftar yang ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="jalur" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#0b5cab]">
                    <x-heroicon-o-map class="h-4 w-4" />
                    <span>Informasi Jalur</span>
                </p>
                <h2 class="font-display mt-2 text-2xl sm:text-4xl font-bold text-[#10233d]">Pilih jalur yang tersedia.</h2>
            </div>
            <p class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs sm:text-sm text-slate-500">
                <x-heroicon-o-chart-pie class="h-4 w-4 text-[#0b5cab]" />
                <span class="font-medium">Status kuota saat ini</span>
            </p>
        </div>

        <div class="mt-8 grid gap-5 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($paths as $path)
                <article class="section-shell flex flex-col justify-between p-5 sm:p-7 transition-transform hover:-translate-y-1">
                    <div>
                        @include('partials.path-badge', ['code' => $path['code']])
                        <h3 class="mt-4 text-2xl font-semibold text-slate-950">{{ $path['name'] }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $path['description'] }}</p>
                        <span @class([
                            'mt-4 inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-semibold uppercase tracking-[0.24em]',
                            'bg-emerald-50 text-emerald-700' => $path['is_selectable'],
                            'bg-rose-50 text-rose-700' => ! $path['is_selectable'],
                        ])>
                            <x-heroicon-o-check-badge class="h-4 w-4" />
                            <span>{{ $path['status_text'] }}</span>
                        </span>
                    </div>

                    <dl class="mt-6 grid grid-cols-3 gap-2 sm:gap-3 text-xs sm:text-sm">
                        <div class="rounded-2xl bg-slate-50/80 p-3 sm:px-4 sm:py-4 border border-slate-100">
                            <dt class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 text-slate-500">
                                <x-heroicon-o-chart-bar class="h-4 w-4 text-blue-400" />
                                <span class="font-medium text-[10px] sm:text-xs uppercase tracking-wider">Kapasitas</span>
                            </dt>
                            <dd class="mt-1 text-base sm:text-lg font-bold text-slate-950">{{ $path['capacity'] }}</dd>
                        </div>
                        <div class="rounded-2xl bg-slate-50/80 p-3 sm:px-4 sm:py-4 border border-slate-100">
                            <dt class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 text-slate-500">
                                <x-heroicon-o-users class="h-4 w-4 text-indigo-400" />
                                <span class="font-medium text-[10px] sm:text-xs uppercase tracking-wider">Terdaftar</span>
                            </dt>
                            <dd class="mt-1 text-base sm:text-lg font-bold text-slate-950">{{ $path['registered'] }}</dd>
                        </div>
                        <div class="rounded-2xl bg-slate-50/80 p-3 sm:px-4 sm:py-4 border border-slate-100">
                            <dt class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 text-slate-500">
                                <x-heroicon-o-clipboard-document-list class="h-4 w-4 text-teal-400" />
                                <span class="font-medium text-[10px] sm:text-xs uppercase tracking-wider">Sisa</span>
                            </dt>
                            <dd class="mt-1 text-base sm:text-lg font-bold text-slate-950">{{ $path['remaining'] }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5">
                        <div class="h-3 rounded-full bg-slate-100">
                            <div class="h-3 rounded-full bg-slate-950" style="width: {{ $path['fill_percentage'] }}%"></div>
                        </div>
                        <p class="mt-2 inline-flex items-center gap-2 text-sm text-slate-500">
                            <x-heroicon-o-chart-pie class="h-4 w-4" />
                            <span>{{ $path['fill_percentage'] }}% kapasitas sudah terpakai.</span>
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

@endsection
