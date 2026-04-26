@extends('layouts.admin')

@section('eyebrow', 'Detail Pendaftar')
@section('page-title', 'Detail '.$registration['full_name'])
@section('title', 'Detail Pendaftar - '.config('spmb.app_name'))

@section('content')
    <section class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    @include('partials.path-badge', ['code' => $registration['path_code']])
                    @include('partials.status-badge', ['status' => $registration['status']])
                </div>
                <h2 class="mt-4 text-3xl font-semibold text-slate-950">{{ $registration['full_name'] }}</h2>
                <p class="mt-2 inline-flex items-center gap-2 text-sm text-slate-500">
                    <x-heroicon-o-identification class="h-4 w-4" />
                    <span>{{ $registration['registration_number'] }}</span>
                    <span>&bull;</span>
                    <x-heroicon-o-calendar-days class="h-4 w-4" />
                    <span>{{ $registration['submitted_at_human'] }}</span>
                </p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('admin.registrants.edit', $registration['id']) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-900">
                    <x-heroicon-o-pencil-square class="h-5 w-5" />
                    <span>Edit Data</span>
                </a>
                <form method="POST" action="{{ route('admin.registrants.destroy', $registration['id']) }}" onsubmit="return confirm('Hapus data pendaftar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full border border-rose-200 px-5 py-3 text-sm font-semibold text-rose-700">
                        <x-heroicon-o-trash class="h-5 w-5" />
                        <span>Hapus</span>
                    </button>
                </form>
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-900" data-print-page>
                    <x-heroicon-o-printer class="h-5 w-5" />
                    <span>Cetak Detail</span>
                </button>
                <a href="{{ route('admin.registrants.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white">
                    <x-heroicon-o-arrow-left class="h-5 w-5" />
                    <span>Kembali ke tabel</span>
                </a>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
        <div class="grid gap-6">
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-50 text-sky-700">
                        <x-heroicon-o-academic-cap class="h-6 w-6" />
                    </span>
                    <h3 class="text-xl font-semibold text-slate-950">Data calon murid</h3>
                </div>
                <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-calendar-days class="h-4 w-4" /><span>Tempat, tanggal lahir</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['birth_place'] }}, {{ $registration['birth_date_human'] }}</dd></div>
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-user class="h-4 w-4" /><span>Jenis kelamin</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['gender_label'] }}</dd></div>
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-identification class="h-4 w-4" /><span>NISN</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['nisn'] ?: '-' }}</dd></div>
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-identification class="h-4 w-4" /><span>NIK</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['nik'] ?: '-' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-map-pin class="h-4 w-4" /><span>Alamat</span></dt><dd class="mt-2 text-sm leading-7 text-slate-700">{{ $registration['address'] }}</dd></div>
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-building-office-2 class="h-4 w-4" /><span>Asal sekolah</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['previous_school'] }}</dd></div>
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-chart-bar class="h-4 w-4" /><span>Usia saat ini</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['age'] }} tahun</dd></div>
                </dl>
            </div>

            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                        <x-heroicon-o-users class="h-6 w-6" />
                    </span>
                    <h3 class="text-xl font-semibold text-slate-950">Data orang tua atau wali</h3>
                </div>
                <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-user-group class="h-4 w-4" /><span>Nama orang tua/wali</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['parent_name'] }}</dd></div>
                    <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-phone class="h-4 w-4" /><span>Nomor HP</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['parent_phone'] }}</dd></div>
                    <div class="sm:col-span-2"><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-envelope class="h-4 w-4" /><span>Email</span></dt><dd class="mt-2 text-sm text-slate-700">{{ $registration['email'] ?: '-' }}</dd></div>
                </dl>
            </div>
        </div>

        <div>
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-50 text-violet-700">
                        <x-heroicon-o-folder-open class="h-6 w-6" />
                    </span>
                    <h3 class="text-xl font-semibold text-slate-950">Informasi jalur</h3>
                </div>

                <div class="mt-6 rounded-[1.75rem] bg-slate-50 px-5 py-5">
                    <p class="inline-flex items-center gap-2 text-sm font-semibold text-slate-950">
                        <x-heroicon-o-squares-2x2 class="h-4 w-4" />
                        <span>{{ $registration['path_name'] }}</span>
                    </p>
                    <dl class="mt-4 grid gap-4 text-sm text-slate-700">
                        @if ($registration['path_code'] === 'DOM')
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-map-pin class="h-4 w-4" /><span>Kelurahan/Desa</span></dt><dd class="mt-2">{{ $registration['village'] }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-map class="h-4 w-4" /><span>Kecamatan</span></dt><dd class="mt-2">{{ $registration['district'] }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-chart-pie class="h-4 w-4" /><span>Jarak rumah ke sekolah</span></dt><dd class="mt-2">{{ $registration['special_data']['distance'] ?? '-' }}</dd></div>
                        @elseif ($registration['path_code'] === 'AFR')
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-clipboard-document-check class="h-4 w-4" /><span>Jenis afirmasi</span></dt><dd class="mt-2">{{ $registration['special_data']['affirmation_type'] ?? '-' }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-identification class="h-4 w-4" /><span>Nomor kartu/program</span></dt><dd class="mt-2">{{ $registration['special_data']['card_number'] ?? '-' }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-document-text class="h-4 w-4" /><span>Keterangan pendukung</span></dt><dd class="mt-2">{{ $registration['special_data']['support_note'] ?? '-' }}</dd></div>
                        @elseif ($registration['path_code'] === 'PRS')
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-trophy class="h-4 w-4" /><span>Jenis prestasi</span></dt><dd class="mt-2">{{ $registration['special_data']['achievement_type'] ?? '-' }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-chart-bar-square class="h-4 w-4" /><span>Tingkat prestasi</span></dt><dd class="mt-2">{{ $registration['special_data']['achievement_level'] ?? '-' }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-document-text class="h-4 w-4" /><span>Nama kompetisi</span></dt><dd class="mt-2">{{ $registration['special_data']['competition_name'] ?? '-' }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-calendar-days class="h-4 w-4" /><span>Tahun prestasi</span></dt><dd class="mt-2">{{ $registration['special_data']['achievement_year'] ?? '-' }}</dd></div>
                        @elseif ($registration['path_code'] === 'MUT')
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-briefcase class="h-4 w-4" /><span>Alasan mutasi</span></dt><dd class="mt-2">{{ $registration['special_data']['mutation_reason'] ?? '-' }}</dd></div>
                            <div><dt class="form-label inline-flex items-center gap-2"><x-heroicon-o-building-office class="h-4 w-4" /><span>Instansi orang tua</span></dt><dd class="mt-2">{{ $registration['special_data']['parent_workplace'] ?? '-' }}</dd></div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </section>
@endsection
