@props(['job'])

<x-panel class="p-6 flex flex-row">
    <div class="flex flex-row flex-1">
        <x-job-logo />
        <div class="flex flex-col ml-5">
            <span class="text-sm text-white/80">{{ $job->employer->name }}</span>
            <h3 class="text-xl font-semibold mt-2 group-hover:text-blue-800 transition-colors duration-300">
                {{ $job->title }}
            </h3>
            <span class="text-sm text-white/80 mt-auto font-semibold">{{ $job->schedule }} - From
                {{ $job->salary }}</span>
        </div>
    </div>

    <div class="flex flex-col items-end">
        <div class="flex flex-row space-x-2">
            {{-- <x-job-tag size="small">{{ $job->schedule }}</x-job-tag>
            <x-job-tag size="small">22h</x-job-tag> --}}
        </div>
        <div class="flex flex-row mt-16 space-x-2">
            @foreach ($job->tags as $tag)
                <x-job-tag size="small" :tag="$tag" />
            @endforeach
        </div>
    </div>
</x-panel>
