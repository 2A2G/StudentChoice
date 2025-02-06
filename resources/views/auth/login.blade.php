<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gradient-to-r from-blue-50 to-blue-100">
        <div class="flex flex-1 items-center justify-center text-center p-6 md:p-10 lg:p-12">
            <div class="bg-white bg-opacity-90 p-8 md:p-12 lg:p-16 rounded-lg shadow-lg max-w-md w-full">
                <div class="flex justify-center mb-6">
                    <x-authentication-card-logo class="w-32 h-32 md:w-40 md:h-40" />
                </div>
                <h1 class="text-4xl font-lobster text-pink-800 drop-shadow-lg mb-4">
                    INICIAR SESIÓN
                </h1>
                <x-validation-errors class="mb-4" />
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="Usuario" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                        </label>
                    </div>

                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md"
                                href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif

                        <x-button
                            class="rounded-full bg-blue-600 px-6 py-3 text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Iniciar Sesión
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
