@props(['tag', 'size' => 'base'])

@php

    $classes = 'bg-white/10 rounded-xl hover:bg-white/5 transition-colors duration-300';

    if ($size == 'base') {
        $classes .= ' px-4 py-1.5 text-md';
    } else {
        $classes .= ' px-3 py-1 text-xs';
    }

@endphp

<a href="/tags/{{ $tag->name }}" class="{{ $classes }}">
    {{ $tag->name }}
</a>
