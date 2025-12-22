@props(['type' => 'text', 'name'])

<input
    {{ $attributes([
        'type' => $type,
        'name' => $name,
        'class' => 'bg-white/10 rounded-xl p-3.5 border border-white/10',
    ]) }} />
