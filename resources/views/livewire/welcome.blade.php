<div>
    <x-guest-layout>
        <div class="min-h-screen flex flex-col bg-gradient-to-r from-blue-50 to-blue-100">
            <div class="flex flex-1 items-center justify-center text-center p-6 md:p-10 lg:p-12">
                <div
                    class="bg-white bg-opacity-90 p-8 md:p-12 lg:p-16 rounded-2xl shadow-2xl max-w-2xl md:max-w-4xl lg:max-w-5xl w-full">

                    <!-- Logo -->
                    <div class="flex justify-center mb-8">
                        <x-authentication-card-logo class="w-40 h-40 md:w-48 md:h-48 lg:w-56 lg:h-56" />
                    </div>

                    <!-- Call to Action Buttons -->
                    <div class="flex flex-col items-center gap-6">
                        <a href="{{ route('login') }}"
                            class="rounded-full bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3 md:px-8 md:py-4 lg:px-10 lg:py-5 text-white transition-all hover:from-blue-700 hover:to-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-opacity-75 shadow-xl">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('sveEstudinate') }}"
                            class="rounded-full bg-gradient-to-r from-green-500 to-green-400 px-6 py-3 md:px-8 md:py-4 lg:px-10 lg:py-5 text-white transition-all hover:from-green-600 hover:to-green-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-400 focus-visible:ring-opacity-75 shadow-xl">
                            Sistema de Votación Estudiantil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-guest-layout>
</div>
