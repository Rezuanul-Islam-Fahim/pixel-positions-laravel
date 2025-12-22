@props(['job'])

<x-panel class="p-6 flex flex-row">
    <div class="flex flex-row flex-1">
        <x-job-logo />
        <div class="flex flex-col ml-5">
            <span class="text-sm text-white/80">{{ $job->employer->name }}</span>
            <a href="{{ $job->url }}" target="_blank">
                <h3 class="text-xl font-semibold mt-2 group-hover:text-blue-800 transition-colors duration-300">
                    {{ $job->title }}
                </h3>
            </a>
            <span class="text-sm text-white/80 mt-auto font-semibold">{{ $job->schedule }} - From
                {{ $job->salary }}</span>
        </div>
    </div>

    <div class="flex flex-col items-end">
        <div class="flex flex-row space-x-2">
            <span class="border border-white/20 rounded-full px-3 py-1 text-xs">
                {{ $job->schedule }}
            </span>
        </div>
        <div class="flex flex-row mt-auto space-x-2">
            @foreach ($job->tags as $tag)
                <x-job-tag size="small" :tag="$tag" />
            @endforeach
        </div>
    </div>
</x-panel>
