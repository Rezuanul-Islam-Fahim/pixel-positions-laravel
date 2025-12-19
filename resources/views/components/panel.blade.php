<div
    {{ $attributes->merge([
        'class' =>
            'bg-white/5 rounded-xl border border-transparent hover:border-blue-800 group transition-colors duration-300',
    ]) }}>
    {{ $slot }}
</div>
