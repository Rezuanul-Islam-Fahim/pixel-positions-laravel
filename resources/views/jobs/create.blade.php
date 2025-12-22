<x-layout>
    <div class="text-center">
        <x-general-heading>Create New Post</x-general-heading>

        <x-form.form method="POST" action="/jobs">
            <x-form.field name="title" label="Title" />
            {{-- <x-form.button class="mt-3" label="Login Now" /> --}}
        </x-form.form>
    </div>
</x-layout>
