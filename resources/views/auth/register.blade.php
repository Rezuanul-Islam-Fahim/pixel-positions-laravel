<x-layout>
    <div class="text-center">
        <x-general-heading>Register</x-general-heading>

        <x-form.form method="POST" action="/register" enctype="multipart/form-data">
            <x-form.field name="name" label="Name" />
            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />
            <x-form.field name="password_confirmation" label="Password Confirmation" type="password" />
            <x-form.divider />
            <x-form.field name="employer_name" label="Employer Name" />
            <x-form.field name="employer_logo" label="Employer Logo" type="file" />
            <x-form.button class="mt-3" label="Create Account" />
        </x-form.form>
    </div>
</x-layout>
