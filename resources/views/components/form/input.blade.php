@props(['type'])

<input
    {{ $attributes([
        'type' => $type,
        'class' => 'bg-white/10 rounded-xl p-3.5 border border-white/10',
    ]) }} />
