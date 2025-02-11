<div class="mt-12">

    <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-1 px-4">
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
                <p class="text-sm font-normal text-blue-gray-600 antialiased leading-normal">
                    <span class="block">Total de postulantes</span>
                </p>
                <h4 class="text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
                    <livewire:animated-counter :targetCount="$totalPostulantes" />
                </h4>

                <div class="mt-4">
                    <p class="text-sm font-normal text-blue-gray-600 antialiased">Total de postulantes eliminados</p>
                    <h2 class="text-xl font-medium text-red-500 antialiased">
                        {{ $totalPostulantesEliminados }}
                    </h2>
                </div>
            </div>

        </div>
    </div>

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Postulantes</h2>
                @can('create applicant')
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal" wire:click="cambiar"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            class="w-6 h-6 text-white">
                            <path fill-rule="evenodd"
                                d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2">Nuevo postulante</span>
                    </button>
                @endCan
            </div>
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
            @if ($postulantes->isEmpty())
                <p class="text-center text-gray-500 dark:text-gray-400 py-4">No hay datos para mostrar</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mx-auto">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Estudiante</th>
                                <th scope="col" class="px-6 py-3">Curso</th>
                                <th scope="col" class="px-6 py-3">Cargo</th>
                                <th scope="col" class="px-6 py-3">Año</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                                @can('general deletion or editing')
                                    <th scope="col" class="px-6 py-3">Acción</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($postulantes as $postulante)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $postulante->estudiante->nombre_estudiante . ' ' . $postulante->estudiante->apellido_estudiante ?? 'Sin nombre' }}
                                    </td>
                                    <td class="px-6 py-4">{{ $postulante->curso->nombre_curso ?? 'No' }}</td>
                                    <td class="px-6 py-4">{{ $postulante->cargo->nombre_cargo }}</td>
                                    <td class="px-6 py-4">{{ $postulante->comicio->anio_eleccion ?? 'No especificado' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="{{ $postulante->deleted_at === null ? 'text-blue-500' : 'text-red-500' }}">
                                            {{ $postulante->deleted_at === null ? 'Activo' : 'Eliminado' }}
                                        </span>
                                    </td>
                                    @can('general deletion or editing')
                                        <td class="px-6 py-4 flex space-x-2">
                                            <button wire:click="edit({{ $postulante }})"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Editar
                                            </button>
                                            <button wire:click="preDelete({{ $postulante }})"
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
                    {{ $postulantes->links() }}
                </div>
            @endif
        </div>
    </div>

    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Añadir Postulante</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de numero de identidad -->
                <label class="block mb-2">Número de identidad</label>
                <input type="number" wire:model="numero_identidad" wire:change="buscarEstudiante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required min="0" step="1"
                    oninput="this.value = this.value.slice(0, 10);">
                @error('numeroIdentidad')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
                @if ($mensajeError)
                    <span class="text-red-500">{{ $mensajeError }}</span>
                @endif

                <!-- Campo del nombre -->
                <label class="block mb-2">Nombre del postulante</label>
                <input type="text" wire:model="nombre_postulante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" disabled>

                <!-- Campo del curso -->
                <label class="block mb-2">Curso</label>
                <input type="text" wire:model="curso_postulante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" disabled>

                <!-- Campo del cargo -->
                <label class="block mb-2">Cargo</label>
                <select wire:model="cargo" wire:change="dispatchDataPostulante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                    @endforeach
                </select>
                @error('cargo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror


                <!-- Campo de la eleccion -->
                <label class="block mb-2">Elección</label>
                <select wire:model="eleccion" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un Elección</option>
                    @foreach ($elecciones as $eleccion)
                        <option value="{{ $eleccion->id }}">{{ $eleccion->nombre_eleccion }}</option>
                    @endforeach
                </select>


                <!-- Campo para subir la imagen -->
                <div class="mb-4">
                    <label for="image-upload" class="block text-gray-700 font-bold mb-2">Imagen del postulante</label>
                    <div class="relative">
                        <input type="file" id="image-upload" wire:model="imagen" accept="image/*" class="hidden"
                            required>
                        <button type="button" onclick="document.getElementById('image-upload').click()"
                            class="flex items-center justify-center w-full border border-gray-300 rounded px-3 py-2 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-2"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2">
                                <path
                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a6 6 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0l-2 2m2-2l2 2" />
                            </svg>
                            Subir imagen
                        </button>
                        @error('imagen')
                            <span class="text-red-500 block mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Componente de la carta -->
                @if ($cargo && $curso_postulante)
                    @livewire('cartas.cartas', [
                        'nombre' => $nombre_postulante,
                        'curso' => $curso_postulante,
                        'cargo' => $cargo->nombre_cargo,
                        'imagen' => $imagen,
                    ])

                    <!-- Agregar checkbox para seleccionar cursos, alineados horizontalmente -->
                    <div class="mt-4">
                        <label class="block mb-2">Cursos a los cuales aplica el postulante</label>
                        <div class="flex flex-wrap gap-4">
                            <!-- Ajustamos para que se ajusten al tamaño del contenedor -->
                            @foreach ($cursosDisponibles as $cursoItem)
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="curso_{{ $cursoItem->id }}"
                                        value="{{ $cursoItem->id }}" wire:model="cursos_seleccionados"
                                        class="mr-2"
                                        {{ in_array($cursoItem->id, $cursos_seleccionados) ? 'checked' : '' }}>
                                    <label for="curso_{{ $cursoItem->id }}">{{ $cursoItem->nombre_curso }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @error('cursos_seleccionados')
                    <span class="text-red-500 block mt-2">{{ $message }}</span>
                @enderror

                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="store"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar postulante
                </button>
            </x-slot>
        </x-dialog-modal>

        <x-dialog-modal wire:model="openUpdate">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Actualizar Postulante</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo del nombre -->
                <label class="block mb-2">Nombre del postulante</label>
                <input type="text" wire:model="nombre_postulante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" disabled>

                <!-- Campo del curso -->
                <label class="block mb-2">Curso</label>
                <input type="text" wire:model="curso_postulante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" disabled>

                <!-- Campo del cargo -->
                <label class="block mb-2">Cargo</label>
                <select wire:model="cargo" wire:change="dispatchDataPostulante"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                    @endforeach
                </select>
                @error('cargo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Campo para subir la imagen -->
                <div class="mb-4">
                    <label for="image-upload" class="block text-gray-700 font-bold mb-2">Imagen del postulante</label>
                    <div class="relative">
                        <input type="file" id="image-upload" wire:model="imagen" accept="image/*"
                            class="hidden">
                        <button type="button" onclick="document.getElementById('image-upload').click()"
                            class="flex items-center justify-center w-full border border-gray-300 rounded px-3 py-2 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-2"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2">
                                <path
                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a6 6 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0l-2 2m2-2l2 2" />
                            </svg>
                            Subir imagen
                        </button>
                        @error('imagen')
                            <span class="text-red-500 block mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @livewire('cartas.cartas', [
                    'nombre' => $nombre_postulante,
                    'curso' => $curso_postulante,
                    'cargo' => $cargo->nombre_cargo,
                    'imagen' => $imagen,
                ])

                <!-- Cursos seleccionados -->
                <div class="mt-4">
                    <label class="block mb-2">Cursos a los cuales aplica el postulante</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($cursosDisponibles as $cursoItem)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="curso_{{ $cursoItem->id }}" value="{{ $cursoItem->id }}"
                                    wire:model="cursos_seleccionados" class="mr-2">
                                <label for="curso_{{ $cursoItem->id }}">{{ $cursoItem->nombre_curso }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('cursos_seleccionados')
                    <span class="text-red-500 block mt-2">{{ $message }}</span>
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

                <!-- Botón para actualizar usuario -->
                <br>
                <button wire:click="update"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Actualizar postulante
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
                        Esta acción no se puede deshacer. Todos los datos asociados con este estudiante se perderán
                        de
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
                <h1 class="text-lg font-medium">Filtrar Postulantes</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Filtro por número de identidad -->
                <label class="block mb-2">Número de Identidad</label>
                <input type="number" wire:model="numero_identidad"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" placeholder="Número de identidad">
                @error('numero_identidad')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Filtro por curso -->
                <label class="block mb-2">Curso</label>
                <select wire:model="curso_postulante" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un curso</option>
                    @foreach ($cursosDisponibles as $cursoItem)
                        <option value="{{ $cursoItem->id }}">{{ $cursoItem->nombre_curso }}</option>
                    @endforeach
                </select>
                @error('curso_postulante')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Filtro por cargo -->
                <label class="block mb-2">Cargo</label>
                <select wire:model="cargo" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                    @endforeach
                </select>
                @error('cargo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Filtro por elección -->
                <label class="block mb-2">Elección</label>
                <select wire:model="eleccion" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione una elección</option>
                    @foreach ($elecciones as $eleccion)
                        <option value="{{ $eleccion->id }}">{{ $eleccion->nombre_eleccion }}</option>
                    @endforeach
                </select>
                @error('eleccion')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Filtro por estado -->
                <label class="block mb-2">Estado</label>
                <select wire:model="estado" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un estado</option>
                    <option value="Activo">Activo</option>
                    <option value="Eliminado">Eliminado</option>
                </select>
                @error('estado')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <br>
                <button wire:click="searchPostulante"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Filtrar Postulante
                </button>
            </x-slot>
        </x-dialog-modal>

    </div>
    {{-- Alerrta de notificaciones --}}
    <x-notificacion />

</div>
