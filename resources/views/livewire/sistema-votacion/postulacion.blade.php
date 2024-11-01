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
                    Total de postulantes</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$totalPostulantes" />
                </h4>
            </div>
        </div>
    </div>

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Postulantes</h2>
                <a data-modal-target="static-modal" data-modal-toggle="static-modal" href="#" wire:click="cambiar"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Nuevo postulante</span>
                </a>
            </div>
            @livewire('diagramas.table', ['case' => 'postulantes'])
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
                <input type="text" wire:model="cargo" class="border border-gray-300 rounded px-3 py-2 w-full mb-3"
                    disabled>

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
                @livewire('cartas.cartas', ['nombre' => $nombre_postulante, 'curso' => $curso_postulante, 'cargo' => $cargo, 'imagen' => $imagen])

                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar postulante
                </button>
            </x-slot>
        </x-dialog-modal>

    </div>
    {{-- Alerrta de notificaciones --}}
    <x-notificacion />

</div>
