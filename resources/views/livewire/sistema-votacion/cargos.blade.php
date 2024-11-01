<div class="mt-12">

    <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-1 px-4">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7.171 12.906l-2.153 6.411l2.672-.89l1.568 2.34l1.825-5.183m5.73-2.678l2.154 6.411l-2.673-.89l-1.568 2.34l-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.68 1.68 0 0 1 2.64 0a1.68 1.68 0 0 0 1.515.628a1.68 1.68 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.68 1.68 0 0 1 0 2.639a1.68 1.68 0 0 0-.628 1.515a1.68 1.68 0 0 1-1.866 1.866a1.68 1.68 0 0 0-1.516.628a1.68 1.68 0 0 1-2.639 0a1.68 1.68 0 0 0-1.515-.628a1.68 1.68 0 0 1-1.867-1.866a1.68 1.68 0 0 0-.627-1.515a1.68 1.68 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.68 1.68 0 0 1 9.165 4.3M14 9a2 2 0 1 1-4 0a2 2 0 0 1 4 0" />
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Total de Cargos</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    <livewire:animated-counter :targetCount="$cargos" />
                </h4>
            </div>
        </div>
    </div>

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Cargos</h2>
                <a data-modal-target="static-modal" data-modal-toggle="static-modal" href="#" wire:click="cambiar"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Registrar nuevo Cargo</span>
                </a>
            </div>
            @livewire('diagramas.table', ['case' => 'cargos'])
        </div>

    </div>
    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Registrar Estudiante</h1>
            </x-slot>
            <x-slot name="content">
                <!--Nombre del cargo-->
                <label class="block mb-2">Nombre del cargo</label>
                <input type="text" wire:model.live="nombre_cargo"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('nombre_crgo')
                    {{ $message }}
                @enderror

                <!--Descripcion del cargo-->
                <label class="block mb-2">Descripción del cargo</label>
                <input type="text" wire:model.live="descripcion_cargo"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('descripcion_cargo')
                    {{ $message }}
                @enderror


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
