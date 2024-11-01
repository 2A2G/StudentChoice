<div>

    @if (!$postulantes)
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">No hay postulantes</h1>
        </div>
    @else
        @foreach ($postulantes as $postulante)
        @endforeach
    @endif
    <div
        class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <img class="w-full h-64 object-cover rounded-t-lg" src="https://i.blogs.es/0ca9a6/aa/1366_2000.jpeg"
                alt="Imagen del candidato" />
        </a>
        <div class="px-5 pb-5">
            <a href="#">
                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Nombre </h5>
                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Edad  </h5>
            </a>
        </div>
    </div>



    <button type="submit"
        class="mt-6 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
        Votar
    </button>
</div>
