<x-layout>
    <div class="text-center">
        <x-general-heading>Login</x-general-heading>

        <x-form.form method="POST" action="/login">
            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />
            <x-form.button class="mt-3" label="Login Now" />
        </x-form.form>
    </div>
</x-layout>
