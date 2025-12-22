@props(['label', 'name'])

<div class="flex flex-col text-left">
    @if ($label)
        <x-form.label :name="$name">{{ $label }}</x-form.label>
    @endif
    <div class="bg-white/10 rounded-xl p-3.5 border border-white/10">
        <input type="checkbox" name="{{ $name }}" :value="old($name)" class="mr-2">
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
    <x-form.error name="{{ $name }}" />
</div>
