@extends('layouts.admin')

@section('eyebrow', 'Kapasitas')
@section('page-title', 'Pengaturan Kapasitas Jalur')
@section('title', 'Kapasitas Jalur - '.config('spmb.app_name'))

@section('content')
    @if (session('capacity_message'))
        <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
            {{ session('capacity_message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.capacity.update') }}">
        @csrf
        <section class="mt-6 grid gap-6 xl:grid-cols-3">
            @foreach ($paths as $path)
                <article class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            @include('partials.path-badge', ['code' => $path['code']])
                            <h2 class="mt-4 text-2xl font-semibold text-slate-950">{{ $path['name'] }}</h2>
                        </div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-700">
                            <x-heroicon-o-users class="h-4 w-4" />
                            <span>{{ $path['registered'] }} terdaftar</span>
                        </span>
                    </div>

                    <div class="mt-6 space-y-5">
                        <div>
                            <label class="form-label inline-flex items-center gap-2">
                                <x-heroicon-o-chart-bar class="h-4 w-4" />
                                <span>Kapasitas jalur</span>
                            </label>
                            <div class="mt-2 flex items-center gap-3">
                                <input type="number" name="paths[{{ $path['code'] }}][capacity]" value="{{ old("paths.{$path['code']}.capacity", $path['capacity']) }}" min="{{ $path['registered'] }}" class="form-input">
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-3 text-sm font-medium text-slate-600">
                                    <x-heroicon-o-clipboard-document-list class="h-4 w-4" />
                                    <span>Sisa {{ $path['remaining'] }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="rounded-2xl bg-slate-50 px-4 py-4 text-sm text-slate-700">
                                <span class="flex items-center gap-3">
                                    <input type="checkbox" name="paths[{{ $path['code'] }}][is_active]" value="1" class="h-4 w-4 rounded border-slate-300 text-slate-950 focus:ring-slate-950" @checked(old("paths.{$path['code']}.is_active", $path['is_active']))>
                                    Jalur aktif
                                </span>
                            </label>
                            <label class="rounded-2xl bg-slate-50 px-4 py-4 text-sm text-slate-700">
                                <span class="flex items-center gap-3">
                                    <input type="checkbox" name="paths[{{ $path['code'] }}][close_when_full]" value="1" class="h-4 w-4 rounded border-slate-300 text-slate-950 focus:ring-slate-950" @checked(old("paths.{$path['code']}.close_when_full", $path['close_when_full']))>
                                    Tutup saat penuh
                                </span>
                            </label>
                        </div>

                        @error("paths.{$path['code']}.capacity")
                            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-800">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="rounded-2xl bg-slate-50 px-4 py-4">
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="inline-flex items-center gap-2 text-slate-500">
                                    <x-heroicon-o-chart-pie class="h-4 w-4" />
                                    <span>Keterisian saat ini</span>
                                </span>
                                <span class="font-semibold text-slate-950">{{ $path['fill_percentage'] }}%</span>
                            </div>
                            <div class="mt-3 h-3 rounded-full bg-white">
                                <div class="h-3 rounded-full bg-slate-950" style="width: {{ $path['fill_percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="mt-8 flex justify-end xl:justify-start">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-950 px-7 py-4 text-sm font-semibold text-white hover:bg-slate-800 shadow-xl shadow-slate-200">
                <x-heroicon-o-check-circle class="h-6 w-6" />
                <span>Simpan Semua Pengaturan</span>
            </button>
        </div>
    </form>
@endsection
