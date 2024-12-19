<div>
    <x-notificacion />

    @if ($candidatos->isNotEmpty())
        @php
            $cargoActual = $candidatos->keys()[$paginaActual];
            $postulantesActuales = $candidatos[$cargoActual];
        @endphp

        <!-- Título -->
        <h2 class="font-bold text-2xl text-center mb-6 text-gray-800">
            Postulantes al cargo de {{ $cargoActual }}
        </h2>

        <!-- Cartas de los postulantes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($postulantesActuales as $postulante)
                <button type="button" wire:click="selectCandidato('{{ $postulante->id }}' ,'{{ $cargoActual }}')">
                    <div
                        class="bg-white shadow-lg rounded-lg overflow-hidden text-center flex flex-col items-center p-4 transform hover:scale-105 transition-transform duration-300
                        {{ $selectedCandidato === $postulante->id ? 'bg-blue-500 text-white border-4 border-blue-700' : '' }}">
                        <div class="w-80 h-64 mb-0">
                            <img src="{{ Storage::url($postulante->postulante->fotografia_postulante) }}"
                                alt="Imagen del postulante" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-lg mt-2">
                            {{ $postulante->postulante->estudiante->nombre_estudiante }}
                            {{ $postulante->postulante->estudiante->apellido_estudiante }}
                        </h3>
                    </div>
                </button>
            @empty
                <p class="col-span-full text-center text-gray-500">No hay postulantes disponibles.</p>
            @endforelse

            <!-- Voto en blanco -->
            <button type="button" wire:click="selectCandidato('voto_en_blanco', '{{ $cargoActual }}')">
                <div
                    class="bg-white shadow-lg rounded-lg overflow-hidden text-center flex flex-col items-center p-4 transform hover:scale-105 transition-transform duration-300
                    {{ $selectedCandidato === 'voto_en_blanco' ? 'bg-blue-500 text-white border-4 border-blue-700' : '' }}">
                    <div class="w-80 h-72 mb-0">
                        <img src="{{ Storage::url('imagenes_postulantes/voto_blanco.jpg') }}"
                            alt="Imagen voto en blanco" class="w-full h-full object-fill">
                    </div>
                </div>
            </button>

        </div>

        <!-- Botón Votar -->
        <div class="flex justify-center mt-6">
            <button wire:click="votar"
                class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg transition duration-300">
                Votar
            </button>
        </div>

        <!-- Navegación -->
        <div class="flex justify-between mt-8">
            @if ($paginaActual > 0)
                <button wire:click="paginaAnterior"
                    class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-6 py-2 rounded-lg shadow-md">
                    Anterior
                </button>
            @else
                <span></span>
            @endif

            @if ($paginaActual < count($candidatos) - 1)
                <button wire:click="paginaSiguiente"
                    class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-6 py-2 rounded-lg shadow-md">
                    Siguiente
                </button>
            @endif
        </div>
    @else
        <p class="text-center text-gray-500">No hay postulantes disponibles para mostrar.</p>
        <a type="button" href="{{ route('sveEstudinate') }}"
            class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Volver
        </a>
    @endif


</div>
