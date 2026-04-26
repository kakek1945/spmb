@php
    $styles = [
        'DOM' => 'bg-teal-50 text-teal-700 ring-teal-200',
        'AFR' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'PRS' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'MUT' => 'bg-fuchsia-50 text-fuchsia-700 ring-fuchsia-200',
    ];
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] ring-1 {{ $styles[$code] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
    {{ $code }}
</span>
