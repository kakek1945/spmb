@extends('layouts.admin')

@section('eyebrow', 'Dashboard')
@section('page-title', 'Ringkasan Prapendaftaran')
@section('title', 'Dashboard Admin - '.config('spmb.app_name'))

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-500">Total Pendaftar</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $stats['total_registrations'] }}</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl border border-sky-100 bg-sky-50 text-sky-700 shadow-sm shadow-sky-100/70">
                    <x-heroicon-o-users class="h-5 w-5" />
                </span>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-500">Kapasitas Total</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $stats['total_capacity'] }}</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl border border-violet-100 bg-violet-50 text-violet-700 shadow-sm shadow-violet-100/70">
                    <x-heroicon-o-chart-bar class="h-5 w-5" />
                </span>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-500">Sisa Kapasitas</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $stats['remaining_capacity'] }}</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl border border-amber-100 bg-amber-50 text-amber-700 shadow-sm shadow-amber-100/70">
                    <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                </span>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-500">Valid Prapendaftaran</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $stats['status_counts']['valid'] ?? 0 }}</p>
                </div>
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl border border-emerald-100 bg-emerald-50 text-emerald-700 shadow-sm shadow-emerald-100/70">
                    <x-heroicon-o-clipboard-document-check class="h-5 w-5" />
                </span>
            </div>
        </div>
    </section>

    <section class="mt-6">
        <div class="section-shell">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-start gap-4">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl border border-indigo-100 bg-indigo-50 text-indigo-700 shadow-sm shadow-indigo-100/70">
                        <x-heroicon-o-chart-bar-square class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-indigo-600">Per Jalur</p>
                        <h2 class="mt-1.5 text-xl font-semibold text-slate-950">Kuota dan keterisian</h2>
                    </div>
                </div>
                <a href="{{ route('admin.capacity') }}" class="btn-hero-secondary px-4 py-2 text-xs font-medium">
                    <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />
                    <span>Atur kapasitas</span>
                </a>
            </div>

            <div class="mt-6 space-y-4">
                @foreach ($paths as $path)
                    <div class="rounded-[1.5rem] border border-slate-100 bg-slate-50/90 px-4 py-4 shadow-sm shadow-slate-200/40">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-3">
                                    @include('partials.path-badge', ['code' => $path['code']])
                                    <h3 class="text-sm font-semibold text-slate-950">{{ $path['name'] }}</h3>
                                </div>
                                <p class="mt-1.5 flex items-center gap-2 text-xs text-slate-500">
                                    <x-heroicon-o-user-group class="h-4 w-4" />
                                    <span>{{ $path['registered'] }} / {{ $path['capacity'] }}</span>
                                </p>
                            </div>
                            <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-950">
                                <x-heroicon-o-clipboard-document-list class="h-4 w-4 text-slate-500" />
                                <span>{{ $path['remaining'] }} sisa</span>
                            </span>
                        </div>
                        <div class="mt-4 h-3 rounded-full bg-white">
                            <div class="h-3 rounded-full bg-slate-950" style="width: {{ $path['fill_percentage'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
