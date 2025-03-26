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
                    {{$totalEstudiantesActivos->count()}}
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
                    {{$totalEstudiantes->count()}}
                </h4>
            </div>
        </div>
    </div>

    <div
        class="flex flex-col lg:flex-row items-start lg:items-center justify-between w-full px-4 space-y-4 lg:space-y-0">
        <h2 class="text-2xl font-semibold text-gray-800">Estudiantes</h2>

        <div class="flex flex-wrap gap-2">
            <button wire:click="estudentImport"
                class="flex items-center px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-lg shadow-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path
                        d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 5a1 1 0 012 0v4h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V7z">
                    </path>
                </svg>
                <span class="ml-2">Importar Estudiante</span>
            </button>

            <button wire:click="registrarEstudiante"
                class="flex items-center px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                    <path
                        d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 5a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z">
                    </path>
                </svg>
                <span class="ml-2">Registrar Estudiante</span>
            </button>

            <button wire:click="filter"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6 6A1 1 0 0114 14v4.586a1 1 0 01-.293.707l-4 4A1 1 0 019 23V14a1 1 0 01-.293-.707l-6-6A1 1 0 013 7.586V5z"
                        clip-rule="evenodd" />
                </svg>
                <span class="ml-2">Filtrar</span>
            </button>
        </div>
    </div>

    @if ($estudiantes->isEmpty())
    <p class="text-center text-gray-500 py-4">No hay datos para mostrar</p>
    @else
    <div class="overflow-x-auto mt-4">
        <table class="w-full min-w-max text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $estudiante->numero_identidad }}</td>
                    <td class="px-6 py-4">{{ $estudiante->nombre_estudiante ?? 'Sin nombre' }}</td>
                    <td class="px-6 py-4">{{ $estudiante->apellido_estudiante ?? 'Sin apellido' }}</td>
                    <td class="px-6 py-4">{{ $estudiante->sexo }}</td>
                    <td class="px-6 py-4">{{ $estudiante->curso->nombre_curso ?? 'No asignado' }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $estudiante->deleted_at ? 'text-red-500' : 'text-blue-500' }}">
                            {{ $estudiante->deleted_at ? 'Inactivo' : 'Activo' }}
                        </span>
                    </td>
                    @can('general deletion or editing')
                    <td class="px-6 py-4 flex flex-wrap gap-2">
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
                <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
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
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required min="0" step="1"
                    oninput="this.value = this.value.slice(0, 10);">
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
                <input type="text" wire:model="apellido" class="border border-gray-300 rounded px-3 py-2 w-full mb-3"
                    placeholder="Ingrese el apellido">
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

        <x-dialog-modal wire:model="openImport">
            <x-slot name="title">
                <h1 class="text-xl font-semibold text-gray-800">📥 Importar Estudiantes</h1>
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <label id="fileLabel" class="block font-medium text-gray-700 mb-2">
                        📂 Seleccionar archivo Excel
                    </label>

                    <div
                        class="relative border border-gray-300 rounded-lg px-4 py-3 bg-white flex items-center justify-between cursor-pointer">
                        <span id="fileName" class="text-gray-600 truncate">Ningún archivo seleccionado</span>
                        <input type="file" wire:model="importFile" required
                            class="absolute inset-0 opacity-0 cursor-pointer"
                            onchange="document.getElementById('fileName').innerText = this.files[0] ? this.files[0].name : 'Ningún archivo seleccionado'">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm font-semibold">📎 Subir</span>
                    </div>

                    @error('importFile')
                    <div class="mt-2 flex items-center text-red-600 text-sm">
                        ❌ <span class="ml-1">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3 mt-4 overflow-hidden">
                    <div wire:loading wire:target="importStudents"
                        class="h-3 w-full bg-gradient-to-r from-blue-500 via-blue-700 to-blue-500 animate-[pulse_1.5s_linear_infinite]">
                    </div>
                </div>


                <div class="flex justify-end mt-6">
                    <button wire:click="importStudents" wire:loading.attr="disabled"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-all ease-in-out duration-300 flex items-center">
                        <span wire:loading.remove wire:target="importStudents">📤 Importar Estudiantes</span>
                        <span wire:loading wire:target="importStudents">⏳ Importando...</span>
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </div>

    {{-- Alerrta de notificaciones --}}
    <x-notificacion />

</div>
