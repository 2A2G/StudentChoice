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
                    Total de Estudiantes Activos</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalEstudiantesActivos->count()" />
                </h4>
            </div>
        </div>

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
                    Total de Estudiantes en el sistema</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalEstudiantes->count()" />
                </h4>
            </div>
        </div>
    </div>

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Estudiantes</h2>
                <button wire:click="cambiar"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Registrar Estudiante</span>
                </button>
            </div>
            <div>
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
                <br>
                @if ($estudiantes->isEmpty())
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">No hay datos para mostrar</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mx-auto">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Número de Identidad</th>
                                    <th scope="col" class="px-6 py-3">Nombre</th>
                                    <th scope="col" class="px-6 py-3">Apellido</th>
                                    <th scope="col" class="px-6 py-3">Sexo</th>
                                    <th scope="col" class="px-6 py-3">Curso</th>
                                    <th scope="col" class="px-6 py-3">Estado</th>
                                    @can('general deletion or editing')
                                        <th scope="col" class="px-6 py-3">Acción</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $estudiante)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">{{ $estudiante->numero_identidad }}</td>
                                        <td class="px-6 py-4">{{ $estudiante->nombre_estudiante ?? 'Sin nombre' }}</td>
                                        <td class="px-6 py-4">{{ $estudiante->apellido_estudiante ?? 'Sin apellido' }}
                                        </td>
                                        <td class="px-6 py-4">{{ $estudiante->sexo }}</td>
                                        <td class="px-6 py-4">{{ $estudiante->curso->nombre_curso ?? 'No asignado' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="{{ $estudiante->deleted_at === null ? 'text-blue-500' : 'text-red-500' }}">
                                                {{ $estudiante->deleted_at === null ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        @can('general deletion or editing')
                                            <td class="px-6 py-4 flex space-x-2">
                                                <button wire:click="edit({{ $estudiante }})"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Editar
                                                </button>
                                                <button wire:click="preDelete({{ $estudiante }})"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Eliminar
                                                </button>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $estudiantes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Registrar Estudiante</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de nombre completo -->
                <label class="block mb-2">Número de identidad</label>
                <input type="number" wire:model.live="numero_identidad"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required min="0" step="1"
                    oninput="this.value = this.value.slice(0, 10);">
                @error('numero_identidad')
                    {{ $message }}
                @enderror
                <label class="block mb-2">Nombre</label>
                <input type="text" wire:model.live="nombre_estudiante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('nombre_estudiante')
                    {{ $message }}
                @enderror
                <label class="block mb-2">Apellido</label>
                <input type="text" wire:model.live="apellido_estudiante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('apellido_estudiante')
                    {{ $message }}
                @enderror


                <!-- Campo de selección de curso del estudiante -->
                <label class="block mb-2">Selecione el Sexo</label>
                <select wire:model="sexo" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                @error('sexo')
                    {{ $message }}
                @enderror

                <label class="block mb-2">Selecione el curso</label>
                <select wire:model="curso_id" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un curso</option>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso['id'] }}">{{ $curso['nombre_curso'] }}</option>
                    @endforeach
                </select>
                @error('curso_id')
                    {{ $message }}
                @enderror

                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="store"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar Estudiante
                </button>
            </x-slot>

        </x-dialog-modal>

        <x-dialog-modal wire:model="openUpdate">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Actualizar Estudiante</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de nombre completo -->
                <label class="block mb-2">Número de identidad</label>
                <input type="number" disabled wire:model.live="numero_identidad"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required min="0"
                    step="1" oninput="this.value = this.value.slice(0, 10);">
                @error('numero_identidad')
                    {{ $message }}
                @enderror
                <label class="block mb-2">Nombre</label>
                <input type="text" disabled wire:model.live="nombre_estudiante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('nombre_estudiante')
                    {{ $message }}
                @enderror
                <label class="block mb-2">Apellido</label>
                <input type="text" disabled wire:model.live="apellido_estudiante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('apellido_estudiante')
                    {{ $message }}
                @enderror


                <!-- Campo de selección de curso del estudiante -->
                <label class="block mb-2">Selecione el Sexo</label>
                <select wire:model="sexo" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                @error('sexo')
                    {{ $message }}
                @enderror

                <label class="block mb-2">Seleccione el curso</label>
                <select wire:model="curso_id" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un curso</option>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso['id'] }}">
                            {{ $curso['nombre_curso'] }}
                        </option>
                    @endforeach
                </select>
                @error('curso_id')
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
                    Actualizar Estudiante
                </button>
            </x-slot>

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
                        ¿Está seguro de eliminar este estudiante?
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

        <x-dialog-modal wire:model="openFilter">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Filtrar Estudiantes</h1>
            </x-slot>
            <x-slot name="content">

                <label class="block mb-2">Número de Identidad</label>
                <input type="text" wire:model="numero_identidad"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3"
                    placeholder="Ingrese el número de identidad">
                @error('numero_identidad')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <label class="block mb-2">Nombre</label>
                <input type="text" wire:model="name" class="border border-gray-300 rounded px-3 py-2 w-full mb-3"
                    placeholder="Ingrese el nombre">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <label class="block mb-2">Apellido</label>
                <input type="text" wire:model="apellido"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" placeholder="Ingrese el apellido">
                @error('apellido')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <label class="block mb-2">Sexo</label>
                <select wire:model="sexo" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione el sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                @error('sexo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <label class="block mb-2">Selecione el curso</label>
                <select wire:model="curso_id" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un curso</option>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso['id'] }}">{{ $curso['nombre_curso'] }}</option>
                    @endforeach
                </select>
                @error('curso_id')
                    {{ $message }}
                @enderror

                <label class="block mb-2">Estado</label>
                <select wire:model="estado" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione el estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Eliminado">Eliminado</option>
                </select>
                @error('estado')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <br>
                <button wire:click="searchStudents"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Filtrar Estudiantes
                </button>
            </x-slot>
        </x-dialog-modal>

    </div>

    {{-- Alerrta de notificaciones --}}
    <x-notificacion />

</div>
