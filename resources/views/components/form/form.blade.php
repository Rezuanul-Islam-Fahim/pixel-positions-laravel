<form
    {{ $attributes([
        'class' => 'flex flex-col gap-y-6 w-2xl mx-auto mb-20',
        'method' => 'GET',
    ]) }}>
    @if ($attributes->get('method', 'GET') !== 'GET')
        @csrf
        @method($attributes->get('method'))
    @endif
    {{ $slot }}
</form>
