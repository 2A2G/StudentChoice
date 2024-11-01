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
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Total de Docentes</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalDocente->count()"/>
                </h4>
            </div>
        </div>
    </div>

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Docentes</h2>
                <a data-modal-target="static-modal" data-modal-toggle="static-modal" href="#" wire:click="cambiar"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Registrar Docente</span>
                </a>
            </div>
            @livewire('diagramas.table', ['case' => 'docentes'])
        </div>

    </div>
    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Registrar Docente</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de nombre completo -->
                <label class="block mb-2">Numero de Identificación</label>

                <input type="number" wire:model.live="numero_identidad"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required min="0" step="1"
                    oninput="this.value = this.value.slice(0, 10);">
                @error('numero_identidad')
                    {{ $message }}
                @enderror
                <label class="block mb-2">Nombre Completo</label>
                <input type="text" wire:model.live="name_docente"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('name_docente')
                    {{ $message }}
                @enderror

                <label class="block mb-2">Correo Electronico</label>
                <input type="email" wire:model.live="email"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('email')
                    {{ $message }}
                @enderror


                <!-- Campo de selección de sexo del estudiante -->
                <label class="block mb-2">Seleccione el Sexo</label>
                <select wire:model="sexo" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>

                <!-- Campo de selección de asignatura -->
                <label class="block mb-2">Seleccione la Asignatura</label>
                <select wire:model="asignatura" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione una asignatura</option>
                    <option value="Matemáticas">Matemáticas</option>
                    <option value="Español">Español</option>
                    <option value="Ciencias Sociales">Ciencias Sociales</option>
                    <option value="Ciencias Naturales">Ciencias Naturales</option>
                    <option value="Inglés">Inglés</option>
                    <option value="Educación Física">Educación Física</option>
                    <option value="Artística">Artística</option>
                    <option value="Tecnología e Informática">Tecnología e Informática</option>
                    <option value="Ética y Valores">Ética y Valores</option>
                    <option value="Religión">Religión</option>
                </select>

                <!-- Campo de selección de curso -->
                <label class="block mb-2">¿Es director de curso?</label>
                <select wire:model="curso_id" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="">Seleccione un curso</option>
                    @foreach ($cursos as $curso)
                        <option value="{{ $curso['id'] }}">{{ $curso['nombre_curso'] }}</option>
                    @endforeach
                </select>




                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar Estudiante
                </button>
            </x-slot>

        </x-dialog-modal>

    </div>
    {{-- Alerrta de notificaciones --}}
    <x-notificacion />


</div>
