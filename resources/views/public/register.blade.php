@extends('layouts.public')

@section('title', 'Form Prapendaftaran - '.config('spmb.app_name'))

@section('content')
    @php($hasSelectedPath = filled($selectedPath))

    <section class="mx-auto max-w-7xl px-4 py-6 sm:py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <div>
                <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-[#10233d]">Form Prapendaftaran</h1>
                <p class="mt-3 inline-flex max-w-3xl items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <x-heroicon-o-identification class="h-5 w-5 text-[#0b5cab]" />
                    <span class="font-medium">NISN wajib diisi dan hanya bisa digunakan satu kali.</span>
                </p>

                @if ($errors->any())
                    <div class="mt-8 rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                        <p class="inline-flex items-center gap-2 font-semibold">
                            <x-heroicon-o-exclamation-triangle class="h-5 w-5" />
                            <span>Masih ada data yang perlu dilengkapi:</span>
                        </p>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('registration.store') }}" class="mt-8 space-y-8" novalidate data-registration-form>
                    @csrf

                    <section class="section-shell p-5 sm:p-7">
                        <div @class([
                            'rounded-2xl sm:rounded-3xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-900',
                            'hidden' => $hasSelectedPath,
                        ]) data-path-notice role="alert">
                            <p class="inline-flex items-center gap-2 font-semibold">
                                <x-heroicon-o-hand-raised class="h-5 w-5" />
                                <span>Pilih jalur pendaftaran terlebih dahulu.</span>
                            </p>
                            <p class="mt-1 text-amber-800">Form akan aktif setelah salah satu jalur dipilih.</p>
                        </div>

                        @error('path_code')
                            <div class="mt-4 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-800">
                                <span class="inline-flex items-center gap-2">
                                    <x-heroicon-o-exclamation-circle class="h-5 w-5" />
                                    <span>{{ $message }}</span>
                                </span>
                            </div>
                        @enderror

                        <div class="grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($paths as $path)
                                <label @class([
                                    'group rounded-[1.5rem] sm:rounded-[1.75rem] border p-4 sm:p-5 transition-all duration-200',
                                    'cursor-pointer border-slate-200 bg-slate-50/70 hover:border-slate-400 hover:-translate-y-1 hover:shadow-md' => $path['is_selectable'],
                                    'cursor-not-allowed border-rose-200 bg-rose-50/80 opacity-70' => ! $path['is_selectable'],
                            'border-[#0b5cab] bg-blue-50 ring-1 ring-[#0b5cab] shadow-md' => $selectedPath === $path['code'] && $path['is_selectable'],
                        ])>
                                    <input
                                        type="radio"
                                        name="path_code"
                                        value="{{ $path['code'] }}"
                                        class="sr-only"
                                        data-path-input
                                        {{ old('path_code', $selectedPath) === $path['code'] ? 'checked' : '' }}
                                        {{ $path['is_selectable'] ? '' : 'disabled' }}
                                    >
                                    <div>
                                        @include('partials.path-badge', ['code' => $path['code']])
                                        <h3 class="mt-4 text-lg font-semibold text-slate-950">{{ $path['name'] }}</h3>
                                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $path['description'] }}</p>
                                        <span @class([
                                            'mt-4 inline-flex items-center gap-2 rounded-full px-3 py-2 text-[11px] font-semibold uppercase tracking-[0.24em]',
                                            'bg-emerald-100 text-emerald-700' => $path['is_selectable'],
                                            'bg-rose-100 text-rose-700' => ! $path['is_selectable'],
                                        ])>
                                            @if ($path['is_selectable'])
                                                <x-heroicon-o-check-badge class="h-4 w-4" />
                                            @else
                                                <x-heroicon-o-no-symbol class="h-4 w-4" />
                                            @endif
                                            <span>{{ $path['status_text'] }}</span>
                                        </span>
                                    </div>
                                    <div class="mt-5 flex items-center justify-between text-sm">
                                        <span class="inline-flex items-center gap-2 text-slate-500">
                                            <x-heroicon-o-clipboard-document-list class="h-4 w-4" />
                                            <span>Sisa kuota</span>
                                        </span>
                                        <span class="font-semibold text-slate-950">{{ $path['remaining'] }}/{{ $path['capacity'] }}</span>
                                    </div>
                                    <p class="mt-4 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">
                                        <x-heroicon-o-cursor-arrow-rays class="h-4 w-4" />
                                        <span>{{ $path['is_selectable'] ? 'Klik untuk pilih jalur ini' : 'Jalur tidak dapat dipilih' }}</span>
                                    </p>
                                </label>
                            @endforeach
                        </div>
                    </section>

                    <section @class([
                        'section-shell p-5 sm:p-7 transition-opacity duration-300',
                        'opacity-50 pointer-events-none' => ! $hasSelectedPath,
                    ]) data-path-dependent-section>
                        <p class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#0b5cab]">
                            <x-heroicon-o-academic-cap class="h-4 w-4" />
                            <span>Langkah 1</span>
                        </p>
                        <h2 class="mt-1 sm:mt-2 text-xl sm:text-2xl font-bold text-[#10233d]">Data calon murid</h2>

                        <div @class([
                            'mt-4 sm:mt-5 rounded-2xl sm:rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-600',
                            'hidden' => $hasSelectedPath,
                        ]) data-path-required-message>
                            Pilih jalur pendaftaran agar bagian ini bisa diisi.
                        </div>

                        <div class="mt-6 grid gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="form-label">Nama lengkap calon murid</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-input" placeholder="Nama lengkap sesuai dokumen sekolah" required>
                            </div>
                            <div>
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-input" inputmode="numeric" placeholder="10 digit NISN" required>
                            </div>
                            <div>
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik') }}" class="form-input" inputmode="numeric" placeholder="Opsional sesuai kebutuhan">
                            </div>
                            <div>
                                <label class="form-label">Tempat lahir</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="form-input" placeholder="Kota kelahiran" required>
                            </div>
                            <div>
                                <label class="form-label">Tanggal lahir</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">Jenis kelamin</label>
                                <select name="gender" class="form-input" required>
                                    <option value="">Pilih jenis kelamin</option>
                                    @foreach ($genders as $code => $label)
                                        <option value="{{ $code }}" @selected(old('gender') === $code)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Asal sekolah</label>
                                <input type="text" name="previous_school" value="{{ old('previous_school') }}" class="form-input" placeholder="Nama sekolah asal" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label">Alamat domisili</label>
                                <textarea name="address" rows="4" class="form-input" placeholder="Tulis alamat lengkap domisili" required>{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section @class([
                        'section-shell p-5 sm:p-7 transition-opacity duration-300',
                        'opacity-50 pointer-events-none' => ! $hasSelectedPath,
                    ]) data-path-dependent-section>
                        <p class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#0b5cab]">
                            <x-heroicon-o-users class="h-4 w-4" />
                            <span>Langkah 2</span>
                        </p>
                        <h2 class="mt-1 sm:mt-2 text-xl sm:text-2xl font-bold text-[#10233d]">Data orang tua atau wali</h2>

                        <div @class([
                            'mt-4 sm:mt-5 rounded-2xl sm:rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-600',
                            'hidden' => $hasSelectedPath,
                        ]) data-path-required-message>
                            Pilih jalur pendaftaran terlebih dahulu.
                        </div>

                        <div class="mt-6 grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="form-label">Nama orang tua/wali</label>
                                <input type="text" name="parent_name" value="{{ old('parent_name') }}" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">Nomor HP orang tua/wali</label>
                                <input type="tel" name="parent_phone" value="{{ old('parent_phone') }}" class="form-input" inputmode="numeric" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Opsional untuk pengiriman informasi">
                            </div>
                        </div>
                    </section>

                    <section @class([
                        'section-shell p-5 sm:p-7 transition-opacity duration-300',
                        'opacity-50 pointer-events-none' => ! $hasSelectedPath,
                    ]) data-path-dependent-section>
                        <p class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#0b5cab]">
                            <x-heroicon-o-adjustments-horizontal class="h-4 w-4" />
                            <span>Field Khusus</span>
                        </p>
                        <h2 class="mt-1 sm:mt-2 text-xl sm:text-2xl font-bold text-[#10233d]">Lengkapi data tambahan sesuai jalur</h2>

                        <div @class([
                            'mt-4 sm:mt-5 rounded-2xl sm:rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-600',
                            'hidden' => $hasSelectedPath,
                        ]) data-path-required-message>
                            Bagian ini akan menyesuaikan setelah jalur dipilih.
                        </div>

                        <div class="mt-6 space-y-6">
                            <div data-path-fields="DOM" class="{{ old('path_code', $selectedPath) === 'DOM' ? '' : 'hidden' }}">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="form-label">Kelurahan atau desa domisili</label>
                                        <input type="text" name="village" value="{{ old('village') }}" class="form-input" data-conditional-input="DOM">
                                    </div>
                                    <div>
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" name="district" value="{{ old('district') }}" class="form-input" data-conditional-input="DOM">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="form-label">Jarak rumah ke sekolah</label>
                                        <input type="text" name="distance" value="{{ old('distance') }}" class="form-input" placeholder="Opsional, misal 2.5 km">
                                    </div>
                                </div>
                            </div>

                            <div data-path-fields="AFR" class="{{ old('path_code', $selectedPath) === 'AFR' ? '' : 'hidden' }}">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="form-label">Jenis afirmasi</label>
                                        <select name="affirmation_type" class="form-input" data-conditional-input="AFR">
                                            <option value="">Pilih jenis afirmasi</option>
                                            @foreach ($affirmationTypes as $code => $label)
                                                <option value="{{ $code }}" @selected(old('affirmation_type') === $code)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label">Nomor kartu atau program bantuan</label>
                                        <input type="text" name="card_number" value="{{ old('card_number') }}" class="form-input" placeholder="Opsional">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="form-label">Keterangan pendukung</label>
                                        <textarea name="support_note" rows="4" class="form-input" placeholder="Opsional">{{ old('support_note') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div data-path-fields="PRS" class="{{ old('path_code', $selectedPath) === 'PRS' ? '' : 'hidden' }}">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="form-label">Jenis prestasi</label>
                                        <select name="achievement_type" class="form-input" data-conditional-input="PRS">
                                            <option value="">Pilih jenis prestasi</option>
                                            @foreach ($achievementTypes as $code => $label)
                                                <option value="{{ $code }}" @selected(old('achievement_type') === $code)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label">Tingkat prestasi</label>
                                        <select name="achievement_level" class="form-input" data-conditional-input="PRS">
                                            <option value="">Pilih tingkat prestasi</option>
                                            @foreach ($achievementLevels as $code => $label)
                                                <option value="{{ $code }}" @selected(old('achievement_level') === $code)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label">Nama lomba atau kompetisi</label>
                                        <input type="text" name="competition_name" value="{{ old('competition_name') }}" class="form-input" data-conditional-input="PRS">
                                    </div>
                                    <div>
                                        <label class="form-label">Tahun prestasi</label>
                                        <input type="text" name="achievement_year" value="{{ old('achievement_year') }}" class="form-input" inputmode="numeric" placeholder="2025" data-conditional-input="PRS">
                                    </div>
                                </div>
                            </div>

                            <div data-path-fields="MUT" class="{{ old('path_code', $selectedPath) === 'MUT' ? '' : 'hidden' }}">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div class="md:col-span-2">
                                        <label class="form-label">Alasan mutasi / pindah</label>
                                        <input type="text" name="mutation_reason" value="{{ old('mutation_reason') }}" class="form-input" data-conditional-input="MUT" placeholder="Misal: Ikut orang tua pindah tugas">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="form-label">Instansi / Tempat kerja orang tua</label>
                                        <input type="text" name="parent_workplace" value="{{ old('parent_workplace') }}" class="form-input" data-conditional-input="MUT" placeholder="Misal: PT Pertamina / Kemenkes">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                            <button type="submit" class="btn-hero-primary group w-full py-3.5 sm:w-auto sm:py-3 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:shadow-none disabled:hover:translate-y-0" data-submit-button @disabled(! $hasSelectedPath)>
                                <x-heroicon-o-paper-airplane class="h-5 w-5" />
                                <span>Kirim Prapendaftaran</span>
                            </button>
                            <a href="{{ route('home') }}" class="btn-hero-secondary w-full py-3.5 sm:w-auto sm:py-3">
                                <x-heroicon-o-arrow-left class="h-5 w-5 opacity-70" />
                                <span>Kembali ke beranda</span>
                            </a>
                        </div>
                    </section>
                </form>
            </div>

            <aside class="space-y-6">
                <div class="section-shell sticky top-24 p-5 sm:p-7">
                    <p class="inline-flex items-center gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#0b5cab]">
                        <x-heroicon-o-chart-pie class="h-4 w-4" />
                        <span>Status Jalur</span>
                    </p>
                    <div class="mt-5 space-y-4">
                        @foreach ($paths as $path)
                            <div class="rounded-3xl bg-slate-50 px-4 py-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-950">{{ $path['name'] }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $path['status_text'] }}</p>
                                    </div>
                                    @include('partials.path-badge', ['code' => $path['code']])
                                </div>
                                <div class="mt-4 h-2 rounded-full bg-white">
                                    <div class="h-2 rounded-full bg-slate-900" style="width: {{ $path['fill_percentage'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
