@props(['label', 'name', 'type' => 'text'])

<div class="flex flex-col text-left">
    <x-form.label :name="$name">{{ $label }}</x-form.label>
    <x-form.input :type="$type" />
</div>
