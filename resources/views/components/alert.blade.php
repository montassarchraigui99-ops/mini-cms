@props(['type' => 'info', 'title' => null])

@php
    $styles = match ($type) {
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        default => 'bg-blue-50 border-blue-200 text-blue-800',
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border p-4 {$styles}"]) }}>
    @if ($title)
        <p class="font-semibold">{{ $title }}</p>
    @endif
    <div class="text-sm mt-1">
        {{ $slot }}
    </div>
</div>
