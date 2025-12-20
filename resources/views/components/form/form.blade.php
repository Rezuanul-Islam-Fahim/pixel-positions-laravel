<form
    {{ $attributes([
        'class' => 'flex flex-col gap-y-6 w-2xl mx-auto mb-20',
        'action' => '',
        'method' => 'GET',
    ]) }}>
    @if ($attributes->get('method', 'GET') !== 'GET')
        @csrf
        @method($attributes->get('GET'))
    @endif
    {{ $slot }}
</form>
