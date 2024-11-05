<div class="mx-auto p-6 bg-white rounded-lg shadow-md max-w-6xl">
    @if ($estadoVotacion == 'activo')
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Estatus de las Elecciones Institucionales</h1>
        <div class="flex gap-6">
            <!-- Estudiantes disponibles para votar -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md w-1/3">
                <div
                    class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-blue-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#ffffff" fill-rule="evenodd"
                            d="M12 6a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7m-1.5 8a4 4 0 0 0-4 4a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2a4 4 0 0 0-4-4zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293a3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2a4 4 0 0 0-4-4h-1.1a5.5 5.5 0 0 1-.471.762A6 6 0 0 1 19.5 18M4 7.5a3.5 3.5 0 0 1 5.477-2.889a5.5 5.5 0 0 0-2.796 6.293A3.5 3.5 0 0 1 4 7.5M7.1 12H6a4 4 0 0 0-4 4a2 2 0 0 0 2 2h.5a6 6 0 0 1 3.071-5.238A5.5 5.5 0 0 1 7.1 12"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block text-sm font-normal text-blue-gray-600">Estudiantes habilitados</p>
                    <h4 class="block text-2xl font-semibold text-blue-gray-900">
                        <livewire:animated-counter :targetCount="$estudiantesDisponibles" />
                    </h4>
                </div>
            </div>

            <!-- Total de votos actualmente -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md w-1/3">
                <div
                    class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block text-sm font-normal text-blue-gray-600">Total de votos</p>
                    <h4 class="block text-2xl font-semibold text-blue-gray-900">5</h4>
                </div>
            </div>

            <!-- Votos en blanco -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md w-1/3">
                <div
                    class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-blue-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#ffffff" fill-rule="evenodd"
                            d="M12 6a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7m-1.5 8a4 4 0 0 0-4 4a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2a4 4 0 0 0-4-4zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293a3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2a4 4 0 0 0-4-4h-1.1a5.5 5.5 0 0 1-.471.762A6 6 0 0 1 19.5 18M4 7.5a3.5 3.5 0 0 1 5.477-2.889a5.5 5.5 0 0 0-2.796 6.293A3.5 3.5 0 0 1 4 7.5M7.1 12H6a4 4 0 0 0-4 4a2 2 0 0 0 2 2h.5a6 6 0 0 1 3.071-5.238A5.5 5.5 0 0 1 7.1 12"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block text-sm font-normal text-blue-gray-600">Votos en blanco</p>
                    <h4 class="block text-2xl font-semibold text-blue-gray-900">0</h4>
                </div>
            </div>
        </div>

        <!-- Selección de curso -->
        <select wire:change="seleccionarCurso($event.target.value)" name="curso" id="curso"
            class="mt-4 block w-full p-3 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition ease-in-out duration-200">
            <option value="" disabled selected>Seleccione un curso</option>
            @foreach ($cursos as $curso)
                <option value="{{ $curso->id }}">{{ $curso->nombre_curso }}</option>
            @endforeach
        </select>


        <!-- Estadísticas del Curso -->
        @if ($cursoSeleccionado)
            <div class="mt-8 text-center">
                <h2 class="text-xl font-semibold text-gray-800">Estadística del Curso:
                    {{ $cursoSeleccionado->nombre_curso ?? '' }}</h2>
                <br>
                @livewire('diagramas.cartas')
            </div>
        @endif
    @endif
</div>
