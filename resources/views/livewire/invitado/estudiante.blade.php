<div>
    <div class="flex flex-col items-center p-6 bg-white shadow-md rounded-lg max-w-md mx-auto">
        <div class="mb-6">
            <x-authentication-card-logo class="w-24 h-24" />
        </div>
        <p class="text-gray-700 text-lg font-semibold mb-2">Sistema de Votación</p>
        <h1 class="text-2xl font-extrabold text-gray-900 mb-6">INEFRAPASA</h1>

        <!-- Campo de número de identidad -->
        <div class="w-full mb-4">
            <label for="numero_identidad" class="block text-sm font-medium text-gray-700 mb-1">Número de
                identidad</label>
            <input id="numero_identidad" type="number" required wire:model="numero_identidad"
                wire:change="buscarEstudiante"
                class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required min="0" step="1" oninput="this.value = this.value.slice(0, 10);">
            @error('numeroIdentidad')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Entrar</button>


    </div>

    <x-notificacion />

</div>
