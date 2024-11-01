<div class="mt-12">

    <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-1 px-4">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div
                class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#ffffff" fill-rule="evenodd"
                        d="M12 6a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7m-1.5 8a4 4 0 0 0-4 4a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2a4 4 0 0 0-4-4zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293a3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2a4 4 0 0 0-4-4h-1.1a5.5 5.5 0 0 1-.471.762A6 6 0 0 1 19.5 18M4 7.5a3.5 3.5 0 0 1 5.477-2.889a5.5 5.5 0 0 0-2.796 6.293A3.5 3.5 0 0 1 4 7.5M7.1 12H6a4 4 0 0 0-4 4a2 2 0 0 0 2 2h.5a6 6 0 0 1 3.071-5.238A5.5 5.5 0 0 1 7.1 12"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="p-4 text-right">
                <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                    Total de usuarios en el sistema</p>
                <h4
                    class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                    {{ $user }}
                </h4>
            </div>
        </div>
    </div>

    <div class="flex">
        <div class="w-full px-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Usuarios</h2>
                <a data-modal-target="static-modal" data-modal-toggle="static-modal" href="#" wire:click="cambiar"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                        class="w-6 h-6 text-white">
                        <path fill-rule="evenodd"
                            d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1a9 9 0 100 18 9 9 0 000-18zm0 4a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H8a1 1 0 010-2h3V8a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2">Nuevo usuario</span>
                </a>
            </div>
            @livewire('diagramas.table', ['case' => 'usuarios'])
        </div>

    </div>
    <div>
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                <h1 class="text-lg font-medium">Crear nuevo Usuario</h1>
            </x-slot>
            <x-slot name="content">
                <!-- Campo de nombre completo -->
                <label class="block mb-2">Nombre Completo</label>
                <input type="text" wire:model.live="name"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('name')
                    {{ $message }}
                @enderror

                <!-- Campo de correo electrónico -->
                <label class="block mb-2">Correo Electronico</label>
                <input type="email" wire:model.live="email"
                    class="border border-gray-300 rounded px-3 py-2 w-full mb-3" required>
                @error('email')
                    {{ $message }}
                @enderror

                <!-- Campo de selección de rol del usuario -->
                <label class="block mb-2">Rol del usuario</label>
                <select wire:model="role" class="border border-gray-300 rounded px-3 py-2 w-full mb-3">
                    <option value="" selected disabled>Seleccione un rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol['name'] }}">{{ $rol['name'] }}</option>
                    @endforeach
                </select>

                <!-- Botón para guardar usuario -->
                <br>
                <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar usuario
                </button>
            </x-slot>

        </x-dialog-modal>

    </div>
    {{-- Alerrta de notificaciones --}}
    <x-notificacion />


</div>
