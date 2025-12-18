<x-layout>
    <div class="space-y-8">
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
                <x-job-tag-xl>Tag 1</x-job-tag-xl>
                <x-job-tag-xl>Tag 2</x-job-tag-xl>
                <x-job-tag-xl>Tag 3</x-job-tag-xl>
                <x-job-tag-xl>Tag 4</x-job-tag-xl>
                <x-job-tag-xl>Tag 5</x-job-tag-xl>
                <x-job-tag-xl>Tag 6</x-job-tag-xl>
                <x-job-tag-xl>Tag 7</x-job-tag-xl>
                <x-job-tag-xl>Tag 8</x-job-tag-xl>
            </div>
        </section>

        <section>
            <x-section-heading>Recent Jobs</x-section-heading>
        </section>
    </div>
</x-layout>
