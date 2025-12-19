<x-layout>
    <div class="space-y-12">
        <section class="text-center py-5">
            <h2 class="font-bold text-4xl mb-8">Let's Find You a Great Job</h2>
            <form action="">
                <input type="text" placeholder="Web developer..."
                    class="px-4 py-3.5 rounded-xl bg-white/10 w-full max-w-2xl border border-white/10">
            </form>
        </section>
        <section>
            <x-section-heading>Top Jobs</x-section-heading>

            <div class="grid lg:grid-cols-3 gap-6 mt-6">
                @foreach ($featuredJobs as $job)
                    <x-job-card :job="$job" />
                @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Tags</x-section-heading>

            <div class="flex flex-wrap mt-6 gap-2">
                @foreach ($tags as $tag)
                    <x-job-tag :tag="$tag" />
                @endforeach
            </div>
        </section>

        <section class="mb-10">
            <x-section-heading>Recent Jobs</x-section-heading>

            <div class="mt-6 space-y-6">
                @foreach ($jobs as $job)
                    <x-job-card-wide :job="$job" />
                @endforeach
            </div>
        </section>
    </div>
</x-layout>
