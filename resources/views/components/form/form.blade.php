@props(['method'])

<form
    {{ $attributes([
        'class' => 'flex flex-col gap-y-6 w-2xl mx-auto mb-20',
        'action' => '',
        'method' => $method,
    ]) }}>
    {{ $slot }}
</form>
