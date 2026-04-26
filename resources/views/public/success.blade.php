@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil - '.config('spmb.app_name'))

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2.25rem] border border-slate-200/80 bg-white/90 p-6 shadow-2xl shadow-slate-200/70 sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <span class="inline-flex rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-700">Pendaftaran Berhasil</span>
                    <h1 class="font-display mt-5 text-4xl font-semibold text-slate-950">Nomor pendaftaran Anda sudah dibuat.</h1>
                    <p class="mt-4 max-w-2xl text-base leading-8 text-slate-600">Status pendaftaran langsung valid dan nomor ini bisa dicetak oleh pendaftar.</p>
                </div>
                @include('partials.path-badge', ['code' => $registration['path_code']])
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div class="rounded-3xl bg-slate-50 px-5 py-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Nomor pendaftaran</p>
                    <p class="mt-3 text-lg font-semibold text-slate-950">{{ $registration['registration_number'] }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 px-5 py-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Nama pendaftar</p>
                    <p class="mt-3 text-lg font-semibold text-slate-950">{{ $registration['full_name'] }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 px-5 py-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Jalur</p>
                    <p class="mt-3 text-lg font-semibold text-slate-950">{{ $registration['path_name'] }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 px-5 py-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Tanggal daftar</p>
                    <p class="mt-3 text-lg font-semibold text-slate-950">{{ $registration['submitted_at_human'] }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 px-5 py-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Status</p>
                    <p class="mt-3 text-lg font-semibold text-emerald-700">{{ $registration['status_label'] }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 rounded-[2rem] bg-slate-950 p-6 text-white lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-teal-300">Bukti Pendaftaran</p>
                    <p class="mt-3 text-sm leading-7 text-slate-300">Simpan atau cetak nomor ini untuk arsip pendaftar.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <button type="button" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950" data-print-page>Cetak Nomor</button>
                    <a href="{{ route('registration.create') }}" class="rounded-full border border-white/15 px-5 py-3 text-sm font-semibold text-white">Daftar Lagi</a>
                </div>
            </div>
        </div>
    </section>
@endsection
