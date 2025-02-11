<div class="row mt-4">
    <div class="col-md-12">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if (empty($data))
                <p class="text-center text-gray-500 dark:text-gray-400 py-4">
                    No hay datos para mostrar
                </p>
            @else
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
                    <br>
                </x-slot>
            </x-dialog-modal>
        </div>
        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $pagination->links() }} <!-- Muestra los enlaces de paginación -->
            <br>
        </div>
    </div>
</div>
