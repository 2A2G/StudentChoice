<div class="max-w-5xl mx-auto p-6">
    @foreach ($postulantes as $indice => $coleccion)
        @if ($coleccion->isNotEmpty())
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">
                @switch($indice)
                    @case(0)
                        Representantes de Curso
                    @break

                    @case(1)
                        Contralores
                    @break

                    @case(2)
                        Personeros
                    @break
                @endswitch
            </h2>

            @foreach ($coleccion as $postulante)
                <div class="w-full mb-6">
                    <div class="border rounded-lg shadow-lg cursor-pointer transition-transform transform hover:scale-105
                                {{ $selectedCandidato === $postulante->id ? 'bg-red-500 text-white' : 'bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-white' }}"
                        wire:click="selectCandidato({{ $postulante->id }})">
                        <a href="#" class="block overflow-hidden rounded-t-lg">
                            <img class="w-full h-56 object-cover"
                                src="{{ $postulante->fotografia_postulante ?? 'https://cdn-icons-png.flaticon.com/512/17236/17236626.png' }}"
                                alt="Imagen del candidato" />
                        </a>
                        <div class="p-5">
                            <h5 class="text-xl font-semibold tracking-tight mb-2">
                                {{ $postulante->nombre ?? 'Nombre del Candidato' }}
                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Paginación -->
            <div class="mt-4">
                {{ $coleccion->links() }}
            </div>
        @endif
    @endforeach

    <!-- Voto en blanco -->
    <div class="w-full mt-6">
        <div class="border rounded-lg shadow-lg cursor-pointer transition-transform transform hover:scale-105 bg-white text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
            wire:click="selectCandidato(null)">
            <a href="#" class="block overflow-hidden rounded-t-lg">
                <img class="w-full h-56 object-cover" src="https://cdn-icons-png.flaticon.com/512/3233/3233483.png"
                    alt="Voto en Blanco" />
            </a>
            <div class="p-5 text-center">
                <h5 class="text-xl font-semibold tracking-tight mb-2">
                    Voto en Blanco
                </h5>
            </div>
        </div>
    </div>
</div>
