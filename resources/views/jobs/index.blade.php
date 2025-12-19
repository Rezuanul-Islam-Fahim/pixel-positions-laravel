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
                <x-job-card></x-job-card>
                <x-job-card></x-job-card>
                <x-job-card></x-job-card>
            </div>
        </section>

        <section>
            <x-section-heading>Tags</x-section-heading>

            <div class="block mt-6 space-x-4">
                <x-job-tag>Tag 1</x-job-tag>
                <x-job-tag>Tag 2</x-job-tag>
                <x-job-tag>Tag 3</x-job-tag>
                <x-job-tag>Tag 4</x-job-tag>
                <x-job-tag>Tag 5</x-job-tag>
                <x-job-tag>Tag 6</x-job-tag>
                <x-job-tag>Tag 7</x-job-tag>
                <x-job-tag>Tag 8</x-job-tag>
            </div>
        </section>

        <section class="mb-10">
            <x-section-heading>Recent Jobs</x-section-heading>

            <div class="mt-6">
                <x-job-card-wide></x-job-card-wide>
            </div>
        </section>
    </div>
</x-layout>
