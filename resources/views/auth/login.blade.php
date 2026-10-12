<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email adresa" style="font-weight: bold; color: #000;" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Lozinka -->
        <div class="mt-4">
            <x-input-label for="password" value="Lozinka" style="font-weight: bold; color: #000;" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Zapamti me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-400 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm font-bold text-black">Zapamti me</span>
            </label>
        </div>

        <!-- Gumbi -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm font-bold text-black hover:text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    Zaboravljena lozinka?
                </a>
            @endif

            <x-primary-button class="ms-3 bg-gray-900 hover:bg-black text-white">
                Prijavi se
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>