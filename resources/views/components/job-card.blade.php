@props(['job'])

<x-panel class="p-4 flex flex-col h-full">
    <span class="self-start text-white/80">{{ $job->employer->name }}</span>

    <div class="text-center p-5">
        <a href="{{ $job->url }}" target="_blank">
            <h2 class="text-xl font-bold group-hover:text-blue-800 transition-colors duration-300">
                {{ $job->title }}
            </h2>
        </a>
        <p class="mt-2 text-sm">{{ $job->schedule }} - From {{ $job->salary }}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div class="flex flex-wrap gap-1">
            @foreach ($job->tags as $tag)
                <x-job-tag size="small" :tag="$tag" />
            @endforeach
        </div>
        <x-job-logo :width="42" />
    </div>

</x-panel>
