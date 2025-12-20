@props(['name'])

<div class="flex flex-row items-center mb-2">
    <span class="w-2.5 h-2.5 inline-block bg-white mr-2"></span>
    <label :name="$name" class="font-bold">{{ $slot }}</label>
</div>
