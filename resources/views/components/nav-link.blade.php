@php
    $active = request()->routeIs($match ?? $to);
@endphp

<a href="{{ route($to) }}" class="{{ $active ? 'text-indigo-600' : 'hover:text-indigo-600' }}">{{ $slot }}</a>
