<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="flex flex-col sm:justify-center items-center h-10">
            <x-button-link class="ml-4" href="{{ route('auth.github') }}">
                <i class="fa-brands fa-github text-3xl mr-2"></i>
                {{ __('Use GitHub') }}
            </x-button-link>
        </div>
    </x-auth-card>
</x-guest-layout>
