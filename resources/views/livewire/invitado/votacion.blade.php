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
                <button type="button"
                    wire:click="selectCandidato('{{ $postulante->postulante_id }}' ,'{{ $cargoActual }}')">
                    <div
                        class="bg-white shadow-lg rounded-lg overflow-hidden text-center flex flex-col items-center p-4 transform hover:scale-105 transition-transform duration-300
                        {{ $selectedCandidato == $postulante->postulante_id ? 'bg-blue-200 text-blue-800 border-4 border-blue-700' : '' }}">
                        <!-- Imagen -->
                        <div class="w-80 h-64 mb-0 relative">
                            <img src="{{ Storage::url('imagenes_postulantes/' . $postulante->postulante->fotografia_postulante) }}"
                                alt="Imagen del postulante" class="w-full h-full object-cover">
                            @if ($selectedCandidato == $postulante->postulante_id)
                                <div class="absolute inset-0 bg-blue-500 opacity-30"></div>
                            @endif
                        </div>

                        <!-- Nombre -->
                        <h3 class="font-semibold text-lg mt-2 relative z-10">
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
                    {{ $selectedCandidato === 'voto_en_blanco' ? 'bg-blue-200 text-blue-800 border-4 border-blue-700' : '' }}">

                    <!-- Imagen Voto en Blanco -->
                    <div class="w-80 h-72 mb-0 relative">
                        <img src="{{ Storage::url('imagenes_postulantes/voto_blanco.jpg') }}"
                            alt="Imagen voto en blanco" class="w-full h-full object-fill">
                        <!-- Marcado Voto en Blanco -->
                        @if ($selectedCandidato === 'voto_en_blanco')
                            <div class="absolute inset-0 bg-blue-500 opacity-30"></div>
                        @endif
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
    @else
        <p class="text-center text-gray-500">No hay postulantes disponibles para mostrar.</p>
        <a type="button" href="{{ route('sveEstudinate') }}"
            class="mt-4 px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Volver
        </a>
    @endif
</div>
