<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mini-CMS' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <x-navbar />

    <main class="max-w-5xl mx-auto px-4 py-8">
        @if (config('site.read_only'))
            <x-alert type="warning" title="Site en lecture seule" class="mb-6">
                Les modifications sont temporairement désactivées.
            </x-alert>
        @endif

        @if (session('success'))
            <x-alert type="success" class="mb-6" role="status">{{ session('success') }}</x-alert>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
