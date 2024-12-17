<div>
    @if ($candidatos->isNotEmpty())
        @php
            $cargoActual = $candidatos->keys()[$paginaActual];
            $postulantesActuales = $candidatos[$cargoActual];
        @endphp

        <h2 class="font-bold text-2xl text-center mb-6 text-gray-800"> Postulantes al cargo de {{ $cargoActual }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($postulantesActuales as $postulante)
                <div
                    class="bg-white shadow-lg rounded-lg overflow-hidden text-center flex flex-col items-center p-4 transform hover:scale-105 transition-transform duration-300">

                    <!-- Imagen del postulante -->
                    <div class="w-80 h-64 mb-0">
                        <img src="{{ Storage::url($postulante->postulante->fotografia_postulante) }}"
                            alt="Imagen del postulante" class="w-full h-full object-cover border border-gray-300">
                    </div>
                    <!-- Nombre del postulante -->
                    <h3 class="font-semibold text-lg text-gray-800 mt-2">
                        {{ $postulante->postulante->estudiante->nombre_estudiante }}
                        {{ $postulante->postulante->estudiante->apellido_estudiante }}
                    </h3>
                </div>

            @empty
                <p class="col-span-full text-center text-gray-500">No hay postulantes disponibles.</p>
            @endforelse

            <div
                class="bg-white shadow-lg rounded-lg overflow-hidden text-center flex flex-col items-center p-4 transform hover:scale-105 transition-transform duration-300">

                <!-- Imagen del postulante -->
                <div class="w-80 h-64 mb-0">
                    <img src="{{ Storage::url('imagenes_postulantes/voto_blanco.jpg') }}" alt="Imagen voto en blanco"
                        class="w-full h-full object-cover border border-gray-300 mb-0">

                </div>
            </div>
        </div>

        <div class="flex justify-between mt-8">
            <!-- Botón Anterior -->
            @if ($paginaActual > 0)
                <button wire:click="paginaAnterior"
                    class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-6 py-2 rounded-lg shadow-md">
                    Anterior
                </button>
            @else
                <span></span>
            @endif

            <!-- Botón Siguiente -->
            @if ($paginaActual < count($candidatos) - 1)
                <button wire:click="paginaSiguiente"
                    class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-6 py-2 rounded-lg shadow-md">
                    Siguiente
                </button>
            @endif
        </div>
    @else
        <p class="text-center text-gray-500">No hay postulantes disponibles para mostrar.</p>
    @endif
</div>
