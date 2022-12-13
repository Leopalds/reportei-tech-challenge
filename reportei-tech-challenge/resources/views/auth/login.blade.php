<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo" >
            <i class="fa-brands fa-github-alt text-9xl" style="filter: invert(100%);"></i>
            <h1 class="text-center font-bold text-white">GitHub Graph</h1>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="flex flex-col sm:justify-center items-center h-10">
            <x-button-link class="ml-4" href="{{ route('auth.github') }}">
                <i class="fa-brands fa-github text-3xl mr-2"></i>
                {{ __('GitHub Log In') }}
            </x-button-link>
        </div>
    </x-auth-card>
</x-guest-layout>
