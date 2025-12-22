@props(['label', 'name'])

<div class="flex flex-col text-left">
    @if ($label)
        <x-form.label :name="$name">{{ $label }}</x-form.label>
    @endif
    <select :name="$name" class="bg-white/10 rounded-xl p-3.5 border border-white/10">
        {{ $slot }}
    </select>
    <x-form.error :name="$name" />
</div>
