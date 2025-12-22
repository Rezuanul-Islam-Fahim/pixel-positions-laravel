@props(['label', 'name', 'type' => 'text'])

<div class="flex flex-col text-left">
    @if ($label)
        <x-form.label :name="$name">{{ $label }}</x-form.label>
    @endif
    <x-form.input :name="$name" :type="$type" />
    <x-form.error :name="$name" />
</div>
