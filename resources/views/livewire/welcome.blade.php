<div>
    <x-guest-layout>
        <div class="min-h-screen flex flex-col bg-gradient-to-r from-blue-50 to-blue-100">
            <div class="flex flex-1 items-center justify-center text-center p-6 md:p-10 lg:p-12">
                <div
                    class="bg-white bg-opacity-90 p-8 md:p-12 lg:p-16 rounded-lg shadow-lg max-w-2xl md:max-w-4xl lg:max-w-5xl w-full">
                    <div class="flex justify-center mb-6">
                        <x-authentication-card-logo class="w-32 h-32 md:w-40 md:h-40" />
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-lobster text-pink-800 drop-shadow-lg mb-4">
                        PROJECT
                    </h1>
                    <h2 class="text-5xl md:text-7xl lg:text-8xl font-lobster text-gray-800 mb-6 drop-shadow-lg">
                        INEFRAPASA
                    </h2>
                    <div class="flex flex-col items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="rounded-full bg-blue-600 px-6 py-3 md:px-8 md:py-4 lg:px-10 lg:py-5 text-white transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-opacity-75">
                            Iniciar Sesion
                        </a>
                        <a href="{{ route('sveEstudinate') }}"
                            class="rounded-full bg-blue-600 px-6 py-3 md:px-8 md:py-4 lg:px-10 lg:py-5 text-white transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-opacity-75">
                            Sistema de Votación Estudiantil
                        </a>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <x-footer class="mt-6" />
        </div>
    </x-guest-layout>
</div>
