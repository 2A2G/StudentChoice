<div class="mt-12">

    <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-2 px-4">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#ffffff" fill-rule="evenodd"
                        d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007c2.759-.038 4.5.16 6.956.791zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Total de Cursos Activos</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalCursosActivos->count()"  :key="'countup-counter-' . $totalCursos->count()"  />
                </h4>
            </div>
        </div>
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#ffffff" fill-rule="evenodd"
                        d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007c2.759-.038 4.5.16 6.956.791zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Total de Cursos en el sistema</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalCursos->count()" />
                </h4>
            </div>
        </div>
    </div>


    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Cursos</h2>
                <a data-modal-target="static-modal" data-modal-toggle="static-modal" href="#" wire:click="cambiar"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Registrar Curso</span>
                </a>
            </div>
            @livewire('diagramas.table', ['case' => 'cursos'])
        </div>

    </div>
    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Registrar Curso</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de nombre para el curso -->
                <label class="block mb-2">Nombre del Curso</label>
                <input type="text" wire:model.live="nombre_curso"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('name_docente')
                    {{ $message }}
                @enderror

                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar Curso
                </button>
            </x-slot>

        </x-dialog-modal>

        <x-dialog-modal wire:model="openUpdate">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Actualizar Curso</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de nombre para el curso -->
                <label class="block mb-2">Nombre del Curso</label>
                <input type="text" wire:model.live="nombre_curso"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('nombre_curso')
                    {{ $message }}
                @enderror

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
                    Actualizar Curso
                </button>
            </x-slot>

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
                            ¿Está seguro de eliminar este curso?
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Esta acción no se puede deshacer. Todos los datos asociados con este curso se perderán de
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
                        ¿Está seguro de eliminar este curso?
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Esta acción no se puede deshacer. Todos los datos asociados con este curso se perderán de
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
