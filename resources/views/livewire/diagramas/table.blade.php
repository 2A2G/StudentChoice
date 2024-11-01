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
                                <th scope="col" class="px-6 py-3">
                                    {{ $column }}
                                </th>
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
                                        <td class="px-6 py-4">
                                            {{ $row[$n] }}
                                        </td>
                                    @endif
                                @endforeach
                                <td class="px-6 py-4">
                                    <button wire:click="openModal('editar',{{$row}})"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Editar
                                    </button>
                                    <button wire:click="openModal('eliminar',{{$row}})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div>
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    <h1 class="text-lg font-medium">{{$type}}  Usuario</h1>
                </x-slot>
                <x-slot name="content">
                    @if ($type === 'Editar')
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            @foreach ($columns as $column)
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex flex-col">
                                        {{-- {{ $column }} --}}
                                        @if($column !== 'estado')
                                            <input type="text" class="mb-2">
                                        @endif
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    
                    <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Guardar usuario
                    </button>
                    @endif
                    @if ($type === 'Eliminar')
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                            ¿Está seguro de eliminar el usuario?
                        </h1>
                        <button wire:click="store" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transform transition-transform hover:scale-105">
                        Eliminar usuario
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
    </div>
</div>
