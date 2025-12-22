<x-layout>
    <div class="text-center">
        <x-general-heading>Create New Post</x-general-heading>

        <x-form.form method="POST" action="/jobs">
            <x-form.field name="title" label="Title" placeholder="CEO" />
            <x-form.field name="salary" label="Salary" placeholder="$50000" />
            <x-form.field name="location" label="Location" placeholder="Winter Park, Florida" />
            <x-form.select name="schedule" label="Schedule">
                <option value="Part Time">Part Time</option>
                <option value="Full Time">Full Time</option>
            </x-form.select>
            <x-form.field name="url" label="Url" placeholder="http://example.com/image.png" />
            <x-form.checkbox name="featured" label="Featured (Costs Extra)" />
            <x-form.divider />
            <x-form.field name="tags" label="Tags (comma separated)" placeholder="laracasts,video,php" />
            <x-form.button class="mt-3" label="Publish" />
        </x-form.form>
    </div>
</x-layout>
