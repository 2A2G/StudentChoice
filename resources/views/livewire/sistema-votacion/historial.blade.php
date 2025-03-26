<div class="mt-12">
    <x-notificacion />

    <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-1 px-4">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="#ffffff" fill-rule="evenodd" clip-rule="evenodd">
                        <path
                            d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6z" />
                        <path
                            d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7z" />
                    </g>
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Total de Registros</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalPostulantesAnios" />
                </h4>
                </h4>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full px-4">
            <div class="flex flex-wrap justify-between items-center gap-2">
                <h2 class="text-2xl font-semibold text-gray-800">Historial de Elecciones</h2>
                @can('create election')
                <button data-modal-target="static-modal" data-modal-toggle="static-modal" wire:click="openModal"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-5 h-5 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Crear Elecciones</span>
                </button>
                @endCan
            </div>

            <div class="mt-4">
                <button wire:click="filter"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-5 h-5 text-white">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6 6A1 1 0 0114 14v4.586a1 1 0 01-.293.707l-4 4A1 1 0 019 23V14a1 1 0 01-.293-.707l-6-6A1 1 0 013 7.586V5z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2">Filtrar</span>
                </button>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Elección</th>
                            <th class="px-4 py-3 text-center">Postulantes</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-center">Elección</th>
                            <th class="px-4 py-3 text-center">Comicio</th>
                            <th class="px-4 py-3 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comicioData as $comicio)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $comicio->nombre_eleccion }}</td>
                            <td class="px-4 py-3 text-center">{{ $comicio->postulante_count }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-white text-sm
                                        {{ $comicio->estado ? 'bg-green-500' : 'bg-gray-400' }}">
                                    {{ $comicio->estado ? 'Activo' : 'Finalizado' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-white text-sm
                                        {{ $comicio->estado_eleccion ? 'bg-blue-500' : ($comicio->estado ? 'bg-orange-500' : 'bg-gray-600') }}">
                                    {{ $comicio->estado_eleccion ? 'En Curso' : ($comicio->estado ? 'Pendiente' :
                                    'Finalizada') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-white text-sm
                                        {{ is_null($comicio->deleted_at) ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ is_null($comicio->deleted_at) ? 'Vigente' : 'Eliminado' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="showResults({{ $comicio->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded text-sm flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Ver Resultados
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">No hay datos disponibles</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $comicioData->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
