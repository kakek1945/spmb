@extends('layouts.admin')

@php($isEdit = filled($registration))
@php($specialData = $registration['special_data'] ?? [])

@section('eyebrow', 'Data Pendaftar')
@section('page-title', $isEdit ? 'Edit Pendaftar' : 'Tambah Pendaftar')
@section('title', ($isEdit ? 'Edit' : 'Tambah').' Pendaftar - '.config('spmb.app_name'))

@section('content')
    <section class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
        @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ $formAction }}" class="space-y-8">
            @csrf
            @if ($formMethod !== 'POST')
                @method($formMethod)
            @endif

            <section>
                <h2 class="text-lg font-semibold text-slate-950">Data calon murid</h2>
                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="form-label">Nama lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $registration['full_name'] ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $registration['nisn'] ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $registration['nik'] ?? '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Tempat lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $registration['birth_place'] ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Tanggal lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $registration['birth_date'] ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Jenis kelamin</label>
                        <select name="gender" class="form-input" required>
                            <option value="">Pilih jenis kelamin</option>
                            @foreach ($genders as $code => $label)
                                <option value="{{ $code }}" @selected(old('gender', $registration['gender'] ?? '') === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Asal sekolah</label>
                        <input type="text" name="previous_school" value="{{ old('previous_school', $registration['previous_school'] ?? '') }}" class="form-input" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" rows="4" class="form-input" required>{{ old('address', $registration['address'] ?? '') }}</textarea>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-slate-950">Data orang tua atau wali</h2>
                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="form-label">Nama orang tua/wali</label>
                        <input type="text" name="parent_name" value="{{ old('parent_name', $registration['parent_name'] ?? '') }}" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone', $registration['parent_phone'] ?? '') }}" class="form-input" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $registration['email'] ?? '') }}" class="form-input">
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-slate-950">Jalur dan status</h2>
                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="form-label">Jalur</label>
                        <select name="path_code" class="form-input" required>
                            <option value="">Pilih jalur</option>
                            @foreach ($paths as $path)
                                <option value="{{ $path['code'] }}" @selected(old('path_code', $registration['path_code'] ?? '') === $path['code'])>{{ $path['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input" required>
                            @foreach ($statuses as $key => $status)
                                <option value="{{ $key }}" @selected(old('status', $registration['status'] ?? 'valid') === $key)>{{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Catatan admin</label>
                        <textarea name="admin_note" rows="3" class="form-input">{{ old('admin_note', $registration['admin_note'] ?? '') }}</textarea>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-slate-950">Field jalur</h2>
                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="form-label">Kelurahan/Desa</label>
                        <input type="text" name="village" value="{{ old('village', $registration['village'] ?? '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="district" value="{{ old('district', $registration['district'] ?? '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jarak rumah ke sekolah</label>
                        <input type="text" name="distance" value="{{ old('distance', $specialData['distance'] ?? '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jenis afirmasi</label>
                        <select name="affirmation_type" class="form-input">
                            <option value="">Pilih jenis afirmasi</option>
                            @foreach ($affirmationTypes as $code => $label)
                                <option value="{{ $code }}" @selected(old('affirmation_type', $specialData['affirmation_type'] ?? '') === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Nomor kartu/program</label>
                        <input type="text" name="card_number" value="{{ old('card_number', $specialData['card_number'] ?? '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Jenis prestasi</label>
                        <select name="achievement_type" class="form-input">
                            <option value="">Pilih jenis prestasi</option>
                            @foreach ($achievementTypes as $code => $label)
                                <option value="{{ $code }}" @selected(old('achievement_type', $specialData['achievement_type'] ?? '') === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Tingkat prestasi</label>
                        <select name="achievement_level" class="form-input">
                            <option value="">Pilih tingkat prestasi</option>
                            @foreach ($achievementLevels as $code => $label)
                                <option value="{{ $code }}" @selected(old('achievement_level', $specialData['achievement_level'] ?? '') === $code)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Nama kompetisi</label>
                        <input type="text" name="competition_name" value="{{ old('competition_name', $specialData['competition_name'] ?? '') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Tahun prestasi</label>
                        <input type="text" name="achievement_year" value="{{ old('achievement_year', $specialData['achievement_year'] ?? '') }}" class="form-input">
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Alasan mutasi / pindah</label>
                        <input type="text" name="mutation_reason" value="{{ old('mutation_reason', $specialData['mutation_reason'] ?? '') }}" class="form-input">
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Instansi / Tempat kerja orang tua</label>
                        <input type="text" name="parent_workplace" value="{{ old('parent_workplace', $specialData['parent_workplace'] ?? '') }}" class="form-input">
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Keterangan pendukung</label>
                        <textarea name="support_note" rows="3" class="form-input">{{ old('support_note', $specialData['support_note'] ?? '') }}</textarea>
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-3 sm:flex-row">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white">
                    <x-heroicon-o-check-circle class="h-5 w-5" />
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pendaftar' }}</span>
                </button>
                <a href="{{ route('admin.registrants.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-900">
                    <x-heroicon-o-arrow-left class="h-5 w-5" />
                    <span>Kembali</span>
                </a>
            </div>
        </form>
    </section>
@endsection
