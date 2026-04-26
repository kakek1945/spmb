@php
    $hotFile = public_path('hot');

    // On Vercel serverless, public_path() may not resolve correctly.
    // Try the standard path first, then fall back to __DIR__ based path.
    $manifestCandidates = [
        public_path('build/.vite/manifest.json'),
        public_path('build/manifest.json'),
        base_path('public/build/.vite/manifest.json'),
        base_path('public/build/manifest.json'),
        dirname(__DIR__, 3) . '/public/build/.vite/manifest.json',
        dirname(__DIR__, 3) . '/public/build/manifest.json',
    ];
    $manifestPath = collect($manifestCandidates)->first(fn ($path) => file_exists($path));
    $manifest = $manifestPath ? json_decode(file_get_contents($manifestPath), true) : [];

    // Resolve asset filenames from manifest, with known fallbacks
    $cssFile = $manifest['resources/css/app.css']['file'] ?? 'assets/app.css';
    $jsFile  = $manifest['resources/js/app.js']['file']  ?? 'assets/app2.js';
@endphp

@if (file_exists($hotFile))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <link rel="stylesheet" href="/build/{{ $cssFile }}">
    <script type="module" src="/build/{{ $jsFile }}"></script>
@endif

