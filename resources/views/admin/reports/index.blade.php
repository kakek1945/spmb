@extends('layouts.admin')

@section('eyebrow', 'Laporan')
@section('page-title', 'Laporan Prapendaftaran')
@section('title', 'Laporan - '.config('spmb.app_name'))

@section('content')
    <section class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700">
                    <x-heroicon-o-document-chart-bar class="h-6 w-6" />
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Laporan</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-950">Rekap daftar calon siswa</h2>
                </div>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-900" data-toast-message="Export CSV belum dihubungkan ke backend.">
                    <x-heroicon-o-arrow-down-tray class="h-5 w-5" />
                    <span>Export CSV</span>
                </button>
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-900" data-print-page>
                    <x-heroicon-o-printer class="h-5 w-5" />
                    <span>Cetak PDF</span>
                </button>
            </div>
        </div>
    </section>

    <section class="mt-6 rounded-[2rem] border border-white/80 bg-white p-4 shadow-lg shadow-slate-200/60 sm:p-6">
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">
                    <tr>
                        <th class="px-4 py-4">Nomor</th>
                        <th class="px-4 py-4">Nama</th>
                        <th class="px-4 py-4">Jalur</th>
                        <th class="px-4 py-4">Asal Sekolah</th>
                        <th class="px-4 py-4">Orang Tua</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($rows as $row)
                        <tr>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $row['registration_number'] }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-950">{{ $row['full_name'] }}</td>
                            <td class="px-4 py-4">@include('partials.path-badge', ['code' => $row['path_code']])</td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $row['previous_school'] }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600">
                                <p>{{ $row['parent_name'] }}</p>
                                <p class="mt-1 text-slate-500">{{ $row['parent_phone'] }}</p>
                            </td>
                            <td class="px-4 py-4">@include('partials.status-badge', ['status' => $row['status']])</td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $row['submitted_at_date'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-500">Belum ada data calon siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
