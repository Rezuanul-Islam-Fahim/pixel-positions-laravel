@props(['label'])

<div class="flex ">
    <input
        {{ $attributes([
            'type' => 'submit',
            'value' => $label,
            'class' =>
                'bg-blue-800 hover:bg-blue-900 transition-colors duration-300 rounded-md text-white px-6 py-3 cursor-pointer',
        ]) }} />
</div>
