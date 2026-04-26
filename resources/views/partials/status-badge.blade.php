@php
    $styles = [
        'baru' => 'bg-sky-50 text-sky-700 ring-sky-200',
        'dicek' => 'bg-violet-50 text-violet-700 ring-violet-200',
        'perlu_perbaikan' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'valid' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'ditolak' => 'bg-rose-50 text-rose-700 ring-rose-200',
    ];
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $styles[$status] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
    {{ config("spmb.statuses.$status.label", $status) }}
</span>
