@extends('layouts.admin')

@section('eyebrow', 'Administrator')
@section('page-title', 'Ubah Password')
@section('title', 'Ubah Password - '.config('spmb.app_name'))

@section('content')
    <section class="max-w-2xl rounded-[2rem] border border-white/80 bg-white p-6 shadow-lg shadow-slate-200/60">
        @if (session('password_message'))
            <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                {{ session('password_message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="form-label">Password saat ini</label>
                <input type="password" name="current_password" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Password baru</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Konfirmasi password baru</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white">
                <x-heroicon-o-key class="h-5 w-5" />
                <span>Simpan Password</span>
            </button>
        </form>
    </section>
@endsection
