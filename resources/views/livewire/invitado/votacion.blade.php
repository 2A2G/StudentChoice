<div class="max-w-5xl mx-auto p-6">
    @if ($postulantes)
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">
            Candidatos para ocupar el cargo de {{ $postulantes[0]->cargo->nombre_cargo }}, del grado
            {{ $postulantes[0]->estudiante->curso->nombre_curso }}
        </h1>
        <div class="flex flex-wrap gap-6 justify-center">
            <!-- Tarjetas de candidatos -->
            @foreach ($postulantes as $postulante)
                <div class="w-80 border rounded-lg shadow-lg cursor-pointer transition-transform transform hover:scale-105
                            {{ $selectedCandidato === $postulante->id ? 'bg-red-500 text-white' : 'bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-white' }}"
                    wire:click="selectCandidato({{ $postulante->id }})">
                    <a href="#" class="block overflow-hidden rounded-t-lg">
                        <img class="w-full h-56 object-cover"
                            src="https://cdn-icons-png.flaticon.com/512/17236/17236626.png" alt="Imagen del candidato" />
                    </a>
                    <div class="p-5">
                        <h5 class="text-xl font-semibold tracking-tight mb-2">
                            {{ $postulante->estudiante->nombre_estudiante }}
                            {{ $postulante->estudiante->apellido_estudiante }}
                        </h5>
                    </div>
                </div>
            @endforeach

            <!-- Tarjeta de "Voto en Blanco" -->
            <div class="w-80 border rounded-lg shadow-lg cursor-pointer transition-transform transform hover:scale-105
                        {{ $selectedCandidato === 'voto_en_blanco' ? 'bg-red-500 text-white' : 'bg-gray-50 text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-white' }}"
                wire:click="selectCandidato('voto_en_blanco')">
                <a href="#" class="block overflow-hidden rounded-t-lg">
                    <div class="flex items-center justify-center h-56 bg-gray-200 dark:bg-gray-700">
                        <span class="text-5xl font-bold text-gray-500 dark:text-gray-300">V</span>
                    </div>
                </a>
                <div class="p-5 text-center">
                    <h5 class="text-xl font-semibold tracking-tight">
                        Voto en Blanco
                    </h5>
                </div>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="text-center mt-8">
            <button wire:click="votar"
                class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                Votar
            </button>
        </div>
    @else
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">
            No hay candidatos
        </h1>
    @endif
    <x-notificacion />
</div>
