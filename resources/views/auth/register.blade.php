<x-layout>
    <div class="text-center">
        <h2 class="text-3xl font-bold mb-10">Register</h2>

        <x-form.form method="POST">
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
