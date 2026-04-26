@extends('layouts.admin')

@section('eyebrow', 'Data Pendaftar')
@section('page-title', 'Daftar Pendaftar')
@section('title', 'Pendaftar - '.config('spmb.app_name'))

@section('content')
    <section class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
        <form method="GET" action="{{ route('admin.registrants.index') }}" class="grid gap-4 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <label class="form-label">Cari nama, nomor pendaftaran, atau NISN</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                    </span>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-input pl-12" placeholder="Cari nama, nomor pendaftaran, atau NISN">
                </div>
            </div>
            <div>
                <label class="form-label">Jalur</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                    </span>
                    <select name="path" class="form-input pl-12">
                        <option value="">Semua jalur</option>
                        @foreach ($paths as $path)
                            <option value="{{ $path['code'] }}" @selected(($filters['path'] ?? '') === $path['code'])>{{ $path['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label">Status</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <x-heroicon-o-clipboard-document-check class="h-5 w-5" />
                    </span>
                    <select name="status" class="form-input pl-12">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $key => $status)
                            <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label">Urutkan</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <x-heroicon-o-funnel class="h-5 w-5" />
                    </span>
                    <select name="sort" class="form-input pl-12">
                        <option value="latest" @selected(($filters['sort'] ?? 'latest') === 'latest')>Terbaru</option>
                        <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Terlama</option>
                        <option value="name" @selected(($filters['sort'] ?? '') === 'name')>Nama A-Z</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="form-label">Dari tanggal</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <x-heroicon-o-calendar-days class="h-5 w-5" />
                    </span>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-input pl-12">
                </div>
            </div>
            <div>
                <label class="form-label">Sampai tanggal</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <x-heroicon-o-calendar-days class="h-5 w-5" />
                    </span>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-input pl-12">
                </div>
            </div>
            <div class="flex items-end gap-3 lg:col-span-3">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white">
                    <x-heroicon-o-funnel class="h-5 w-5" />
                    <span>Terapkan Filter</span>
                </button>
                <a href="{{ route('admin.registrants.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-900">
                    <x-heroicon-o-arrow-path class="h-5 w-5" />
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </section>

    <section class="mt-6 rounded-[2rem] border border-white/80 bg-white p-4 shadow-lg shadow-slate-200/60 sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700">
                    <x-heroicon-o-users class="h-6 w-6" />
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-indigo-600">Tabel Pendaftar</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-950">Data pendaftar</h2>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <p class="inline-flex items-center gap-2 text-sm text-slate-500">
                    <x-heroicon-o-document-text class="h-4 w-4" />
                    <span>{{ $registrations->total() }} hasil ditemukan</span>
                </p>
                <a href="{{ route('admin.registrants.create') }}" class="inline-flex items-center gap-2 rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    <span>Tambah</span>
                </a>
            </div>
        </div>

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
                        <th class="px-4 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($registrations as $registration)
                        <tr>
                            <td class="px-4 py-4 text-sm font-medium text-slate-600">{{ $registration['registration_number'] }}</td>
                            <td class="px-4 py-4">
                                <p class="font-semibold text-slate-950">{{ $registration['full_name'] }}</p>
                                <p class="mt-1 text-sm text-slate-500">NISN: {{ $registration['nisn'] ?: '-' }}</p>
                            </td>
                            <td class="px-4 py-4">@include('partials.path-badge', ['code' => $registration['path_code']])</td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $registration['previous_school'] }}</td>
                            <td class="px-4 py-4 text-sm text-slate-600">
                                <p>{{ $registration['parent_name'] }}</p>
                                <p class="mt-1 text-slate-500">{{ $registration['parent_phone'] }}</p>
                            </td>
                            <td class="px-4 py-4">@include('partials.status-badge', ['status' => $registration['status']])</td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $registration['submitted_at_date'] }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.registrants.show', $registration['id']) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600">
                                        <x-heroicon-o-eye class="h-4 w-4" />
                                        <span>Detail</span>
                                    </a>
                                    <a href="{{ route('admin.registrants.edit', $registration['id']) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700">
                                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.registrants.destroy', $registration['id']) }}" onsubmit="return confirm('Hapus data pendaftar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-semibold text-rose-600">
                                            <x-heroicon-o-trash class="h-4 w-4" />
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-sm text-slate-500">Tidak ada data yang cocok dengan filter saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $registrations->links() }}
        </div>
    </section>
@endsection
