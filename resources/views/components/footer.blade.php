<footer class="w-full py-6 bg-white bg-opacity-50 text-gray-800 text-center md:text-left">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0 text-sm">
            <!-- Primera columna -->
            <div class="flex flex-col md:flex-row items-center md:space-x-4">
                <span>Desarrollado por Aldair <span class="font-semibold">AG</span> &copy; {{ date('Y') }}</span>
                <span class="hidden md:inline">|</span>
                <a href="https://github.com/2A2G" class="text-blue-400 hover:text-blue-500 transition" target="_blank"
                    rel="noopener noreferrer">
                    GitHub: @2A2G
                </a>
                <span class="hidden md:inline">|</span>
                <a href="https://co.linkedin.com/in/aldair-guti%C3%A9rrez-guerrero-b002a9274"
                    class="text-blue-400 hover:text-blue-500 transition" target="_blank" rel="noopener noreferrer">
                    LinkedIn: Aldair Gutierrez
                </a>
            </div>

            <!-- Segunda columna -->
            <div class="flex flex-col md:flex-row items-center md:space-x-4">
                <span>Colaborador Adrian <span class="font-semibold"></span> &copy; {{ date('Y') }}</span>
                <span class="hidden md:inline">|</span>
                <a href="https://github.com/Dev-Drian" class="text-blue-400 hover:text-blue-500 transition"
                    target="_blank" rel="noopener noreferrer">
                    GitHub: @Dev-Drian
                </a>
            </div>

            <!-- Tercera columna -->
            <div class="text-gray-600">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>
</footer>
