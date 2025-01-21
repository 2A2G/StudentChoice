<div class="row mt-4">
    <div class="col-md-12">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if (empty($data))
                <p class="text-center text-gray-500 dark:text-gray-400 py-4">
                    No hay datos para mostrar
                </p>
            @else
                <button wire:click="filter"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6 6A1 1 0 0114 14v4.586a1 1 0 01-.293.707l-4 4A1 1 0 019 23V14a1 1 0 01-.293-.707l-6-6A1 1 0 013 7.586V5z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2">Filtrar</span>
                </button>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mx-auto">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            @foreach ($columns as $column)
                                @if ($column === 'Acción')
                                    @can('general deletion or editing')
                                        <th scope="col" class="px-6 py-3">
                                            {{ $column }}
                                        </th>
                                    @endcan
                                @else
                                    <th scope="col" class="px-6 py-3">
                                        {{ $column }}
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                @foreach ($dataI as $n)
                                    @if ($n === 'estado')
                                        <td class="px-6 py-4">
                                            <span
                                                class="{{ $row['estado'] === 'Eliminado' ? 'text-red-500' : 'text-blue-500' }}">
                                                {{ $row['estado'] }}
                                            </span>
                                        </td>
                                    @else
                                        <td class="px-3 py-4">
                                            {{ $row[$n] }}
                                        </td>
                                    @endif
                                @endforeach
                                @can('general deletion or editing')
                                    <td class="px-6 py-4">
                                        <button wire:click="openModal('editar',{{ $row }}, '{{ $case }}')"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Editar
                                        </button>
                                        <button
                                            wire:click="openModal('eliminar',{{ $row }}, '{{ $case }}')"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Eliminar
                                        </button>
                                    </td>
                                @endCan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div>
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    <h1 class="text-lg font-medium">{{ $type }}</h1>
                </x-slot>
                <x-slot name="content">
                    @if ($type === 'Editar')
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                @foreach ($inUpdate[1] as $key => $value)
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex flex-col">
                                            <label for="{{ $key }}"
                                                class="mb-2 font-medium">{{ ucfirst($key) }}</label>

                                            @if ($key === 'estado')
                                                <select id="{{ $key }}"
                                                    wire:model.defer="inUpdate[1].{{ $key }}"
                                                    class="form-select">
                                                    <option value="activo">Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                            @else
                                                <input type="text" id="{{ $key }}"
                                                    wire:model.defer="inUpdate[1].{{ $key }}"
                                                    class="mb-2 form-input" value="{{ $value }}">
                                            @endif
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <button wire:click="update"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-4">
                            Actualizar
                        </button>
                    @endif
                    <!-- Botón para guardar usuario -->
                    <br>
                </x-slot>

            </x-dialog-modal>
        </div>
        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $pagination->links() }} <!-- Muestra los enlaces de paginación -->
            <br>
        </div>

        {{-- Filtrar --}}
        <x-dialog-modal wire:model="openFilter">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Filtrar Docentes</h1>
            </x-slot>
            <x-slot name="content">
                <tr>
                    @foreach ($columns as $column)
                        @if ($column !== 'Acción' || $column !== 'Docente' || $column !== 'Director del Curso')
                            <th scope="col" class="px-6 py-3">
                                {{ $column }}
                            </th>
                        @endif
                    @endforeach
                </tr>

                <label class="block mb-2">Selecione el Estado</label>
                <select wire:model="estado" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Eliminado">Eliminado</option>
                </select>
                @error('estado')
                    {{ $message }}
                @enderror

                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="update"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Filtrar Docente
                </button>
            </x-slot>


        </x-dialog-modal>
    </div>
</div>
