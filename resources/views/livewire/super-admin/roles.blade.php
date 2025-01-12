<div class="mt-12">

    <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-2 px-4">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                    class="w-6 h-6 text-white">
                    <path fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Roles</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalRoles" />
                </h4>
            </div>

        </div>
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-orange-600 to-orange-400 text-white shadow-orange-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                    class="w-6 h-6 text-white">
                    <path
                        d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                    </path>
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Permisos
                </p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalPermisos" />
                </h4>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 p-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Roles</h2>
                @can('create role')
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal" wire:click="openCreateRol"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="w-6 h-6 text-white">
                            <path fill-rule="evenodd"
                                d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2">Crear rol</span>
                    </button>
                @endCan
            </div>
            @livewire('diagramas.table', ['case' => 'roles'])
        </div>
        <div class="w-full sm:w-1/2 p-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Permisos</h2>
            </div>
            @livewire('diagramas.table', ['case' => 'permisos'])
        </div>
    </div>

    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Crear nuevo rol</h1>
            </x-slot>
            <x-slot name="content">
                <label class="block mb-2">Nombre del nuevo rol</label>
                <input type="text" wire:model.live="name_rol"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('name_rol')
                    {{ $message }}
                @enderror

                <div class="mt-4">
                    <label class="block mb-2">Permisos que se aplicarán al rol</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($permisosDisponibles as $permisoItem)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="curso_{{ $permisoItem->id }}" value="{{ $permisoItem->id }}"
                                    wire:model="permiso_seleccionado" class="mr-2"
                                    {{ in_array($permisoItem->id, $permiso_seleccionado) ? 'checked' : '' }}>
                                <label for="curso_{{ $permisoItem->id }}">{{ $permisoItem->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('permiso_seleccionado')
                    <span class="text-red-500 block mt-2">{{ $message }}</span>
                @enderror
                <br>

                <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Crear
                </button>
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model="openUpdate">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Crear nuevo rol</h1>
            </x-slot>
            <x-slot name="content">
                <label class="block mb-2">Nombre del nuevo rol</label>
                <input type="text" wire:model.live="name_rol"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('name_rol')
                    {{ $message }}
                @enderror

                <div class="mt-4">
                    <label class="block mb-2">Permisos que se aplicarán al rol</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($permisosDisponibles as $permisoItem)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="curso_{{ $permisoItem->id }}" value="{{ $permisoItem->id }}"
                                    wire:model="permiso_seleccionado" class="mr-2"
                                    {{ in_array($permisoItem->id, $permiso_seleccionado) ? 'checked' : '' }}>
                                <label for="curso_{{ $permisoItem->id }}">{{ $permisoItem->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('permiso_seleccionado')
                    <span class="text-red-500 block mt-2">{{ $message }}</span>
                @enderror
                <br>

                <label class="block mb-2">Selecione el Estado</label>
                <select wire:model="estado" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Eliminado">Eliminado</option>
                </select>
                @error('estado')
                    {{ $message }}
                @enderror
                <br>

                <button wire:click="update"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Actualizar rol
                </button>
            </x-slot>
            <x-slot name="footer"></x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model="openDelete">
            <x-slot name="title">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Confirmar Eliminación
                </h1>
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-col items-center text-center">
                    <!-- Icono de advertencia -->
                    <div class="mb-4">
                        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z">
                            </path>
                        </svg>
                    </div>

                    <!-- Mensaje principal -->
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">
                        ¿Está seguro de eliminar este rol?
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Esta acción no se puede deshacer. Todos los datos asociados con este estudiante se perderán de
                        forma permanente.
                    </p>
                </div>

                <!-- Botones de acción -->
                <div class="mt-6 flex justify-center gap-4">
                    <button wire:click="$set('openDelete', false)"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-all">
                        Cancelar
                    </button>
                    <button wire:click="delete"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition-all transform hover:scale-105">
                        Eliminar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </div>
    {{-- Alerrta de notificaciones --}}
    <x-notificacion />

</div>
