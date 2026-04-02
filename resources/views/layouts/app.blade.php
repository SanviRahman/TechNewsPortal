<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .page-card { border: 0; border-radius: 16px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08); }
        .table th { white-space: nowrap; }
        .badge-soft { background: #eef2ff; color: #4338ca; }
        .section-title { font-weight: 700; }
        .post-body { line-height: 1.8; }
        .sidebar-card { border: 0; border-radius: 16px; box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06); }
    </style>
    @stack('styles')
</head>
<body>
    <div class="min-vh-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white border-bottom mb-4">
                <div class="container py-3">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="pb-5">
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>