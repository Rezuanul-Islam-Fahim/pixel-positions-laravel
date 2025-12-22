<x-layout>
    <x-general-heading>Results</x-general-heading>
    <div class="mt-6 space-y-6">
        @foreach ($jobs as $job)
            <x-job-card-wide :job="$job" />
        @endforeach
    </div>
</x-layout>
