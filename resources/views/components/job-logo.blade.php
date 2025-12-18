@props(['width' => 100])

<img src="http://picsum.photos/seed/{{ rand(0, 10000) }}/{{ $width }}" alt=""
    class="rounded-md object-cover" style="width: {{ $width }}px; height: {{ $width }}px">
