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

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Historial de Elecciones</h2>
                @can('create election')
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal" wire:click="openModal"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="w-6 h-6 text-white">
                            <path fill-rule="evenodd"
                                d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2">Crear Elecciones</span>
                    </button>
                @endCan
            </div>
            <div>
                <table class="table-auto w-full text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nombre de la Elección</th>
                            <th scope="col" class="px-6 py-3">Cantidad de Postulantes</th>
                            <th scope="col" class="px-6 py-3">Estado del comicio</th>
                            <th scope="col" class="px-6 py-3">Estado de la elección</th>
                            <th scope="col" class="px-6 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comicioData as $comicio)
                            <tr>
                                <td class="px-6 py-4">{{ $comicio->nombre_eleccion }}</td>
                                <td class="px-6 py-4">{{ $comicio->cantidad_postulantes }}</td>

                                <td class="px-6 py-4">
                                    @if ($comicio->estado)
                                        <span class="px-2 py-1 bg-green-500 text-white rounded-full">Activo</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-400 text-white rounded-full">Finalizado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($comicio->estado_eleccion)
                                        <span class="px-2 py-1 bg-blue-500 text-white rounded-full">En Curso</span>
                                    @elseif($comicio->estado)
                                        <span class="px-2 py-1 bg-orange-500 text-white rounded-full">Pendiente</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-600 text-white rounded-full">Finalizada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="showResults({{ $comicio->id }})"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                        Ver resultados
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay datos disponibles
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


                <div class="mt-4">
                    {{ $comicioData->links() }}
                </div>
            </div>
        </div>

        <div>
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    <h1 class="text-lg font-medium">Datos de la elección</h1>
                </x-slot>

                <x-slot name="content">
                    <label class="block mb-2">Nombre de la elección</label>
                    <input type="text" wire:model="nombre_eleccion"
                        class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required maxlength="255">
                    @error('nombre_eleccion')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <br>
                    <button wire:click="store"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Crear Elección
                    </button>
                </x-slot>
            </x-dialog-modal>


            <x-dialog-modal wire:model="openUpdate">
                <x-slot name="title">
                    <h1 class="text-lg font-medium">Datos de la elección</h1>
                </x-slot>

                <x-slot name="content">
                    <label class="block mb-2">Nombre de la elección</label>
                    <input type="text" wire:model="nombre_eleccion"
                        class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required maxlength="255">
                    @error('nombre_eleccion')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <label class="block mb-2">Estado</label>
                    <select wire:model="estado" class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                        <option disabled value="">Seleccione el estado</option>
                        <option value="activa">Activa</option>
                        <option value="inactiva">Inactiva</option>
                    </select>
                    @error('estado')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <br>
                    <button wire:click="store"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Crear Elección
                    </button>
                </x-slot>
            </x-dialog-modal>
        </div>
    </div>
</div>
