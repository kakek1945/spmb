@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil - '.config('spmb.app_name'))

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8" data-success-shell>
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

            <div class="mt-8 rounded-[2rem] border border-dashed border-slate-300 bg-slate-50/90 p-5 sm:p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Pratinjau Cetak</p>
                        <p class="mt-2 text-sm leading-7 text-slate-600">Ukuran kartu dibuat kecil setara KTP agar mudah dicetak dan disimpan.</p>
                    </div>
                    <span class="hidden rounded-full bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500 shadow-sm sm:inline-flex">85.6 x 54 mm</span>
                </div>

                <div class="mt-6 overflow-x-auto pb-2">
                    <article data-print-card class="success-print-card mx-auto text-white">
                        <div class="success-print-card__body">
                            <div class="success-print-card__top">
                                <div class="success-print-card__brand">
                                    <div class="success-print-card__logo-wrap">
                                        <img src="{{ config('spmb.school.logo_url') }}" alt="Logo {{ config('spmb.school.name') }}" class="success-print-card__logo" referrerpolicy="no-referrer">
                                    </div>
                                    <div>
                                        <p class="success-print-card__eyebrow">Kartu Pendaftaran</p>
                                        <p class="success-print-card__school">{{ config('spmb.school.name') }}</p>
                                    </div>
                                </div>
                                <div class="success-print-card__badge">{{ $registration['status_label'] }}</div>
                            </div>

                            <div class="success-print-card__main">
                                <div>
                                    <p class="success-print-card__label">Nomor Pendaftaran</p>
                                    <p class="success-print-card__number">{{ $registration['registration_number'] }}</p>
                                </div>
                                <div class="success-print-card__grid">
                                    <div>
                                        <p class="success-print-card__label">Nama</p>
                                        <p class="success-print-card__value">{{ $registration['full_name'] }}</p>
                                    </div>
                                    <div>
                                        <p class="success-print-card__label">Jalur</p>
                                        <p class="success-print-card__value">{{ $registration['path_name'] }}</p>
                                    </div>
                                    <div>
                                        <p class="success-print-card__label">Tanggal</p>
                                        <p class="success-print-card__value">{{ $registration['submitted_at_date'] }}</p>
                                    </div>
                                    <div>
                                        <p class="success-print-card__label">Tahun</p>
                                        <p class="success-print-card__value">{{ $brand['year'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="success-print-card__footer">
                                <span>Simpan kartu ini sebagai bukti pendaftaran.</span>
                                <span>{{ config('spmb.school.info') }}</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
