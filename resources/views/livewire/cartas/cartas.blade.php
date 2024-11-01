<div class="mt-12 flex justify-center">
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        <img class="w-full h-48 object-cover" src="{{ $imagen }}" alt="imagen del postulante">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2"> Nombre: {{ $nombre }}</div>
            <p class="text-gray-700 text-base">
                Curso: {{ $curso }}
            </p>
            <p class="text-gray-700 text-base">
                Cargo: {{ $cargo }}
            </p>
        </div>
    </div>
</div>
