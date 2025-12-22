@props(['employer', 'width' => 100])

<img src="{{ str_starts_with($employer->logo, 'http') ? $employer->logo : asset('storage/' . $employer->logo) }}"
    alt="" class="rounded-md object-cover" style="width: {{ $width }}px; height: {{ $width }}px">
