<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletín Electoral</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-serif text-gray-900">
    <!-- Primera Página -->
    <div class="page break-after-page">
        <div class="flex flex-col items-center justify-center h-screen px-8 bg-gray-50">
            <h1 class="text-5xl font-extrabold text-center text-blue-900">{{ $nameInstitucion }}</h1>
            <p class="mt-8 text-lg text-justify max-w-3xl text-gray-700 leading-relaxed">
                La institución educativa <span class="font-semibold text-blue-800">{{ $nameInstitucion }}</span>, en
                cumplimiento de lo
                establecido en la <span class="font-semibold">Ley General de Educación (Ley 115 de 1994)</span> y el
                <span class="font-semibold">Decreto 1860 de 1994</span>, presenta los resultados obtenidos en los
                comicios estudiantiles realizados el día
                <span class="font-semibold">{{ \Carbon\Carbon::parse($fechaComicios)->format('d/m/Y') }}</span>.
            </p>
            <p class="mt-6 text-lg text-justify max-w-3xl text-gray-700 leading-relaxed">
                Estos comicios permiten a los estudiantes participar activamente en la vida democrática de la
                institución, eligiendo cargos como <span class="font-semibold">Personero Estudiantil, Contralor
                    Escolar</span> y
                <span class="font-semibold">Representantes de Curso</span>. Dichos roles fomentan el liderazgo, la
                responsabilidad y el compromiso ciudadano, pilares fundamentales para el fortalecimiento de nuestra
                democracia.
            </p>
            <p class="mt-6 text-lg text-justify max-w-3xl text-gray-700 leading-relaxed">
                El proceso electoral fue llevado a cabo utilizando el software <span
                    class="font-semibold text-blue-800">StudentChoice</span>,
                garantizando un mecanismo justo, seguro y transparente, sin evidencias de manipulación alguna. El
                responsable del desarrollo y
                mantenimiento del software es <span class="font-semibold text-gray-800">Aldair Antonio Gutiérrez
                    Guerrero</span>.
            </p>
            <p class="mt-8 text-lg text-center font-semibold text-gray-600">
                A continuación, encontrará información detallada sobre las responsabilidades de los cargos elegidos y
                las normas legales que respaldan este proceso.
            </p>
        </div>
    </div>

    <!-- Tabla de Contenido -->
    <div class="page break-after-page">
        <div class="px-8 py-12 bg-white shadow-md rounded-md">
            <h2 class="text-4xl font-bold text-center text-blue-900">Tabla de Contenido</h2>
            <ul class="mt-8 text-lg text-gray-700 leading-relaxed list-disc list-inside">
                <li>
                    <a href="#responsabilidades-cargos" class="text-blue-600 hover:underline">
                        Responsabilidades de los Cargos
                    </a> - Página 2
                </li>
                <li>
                    <a href="#fundamento-legal" class="text-blue-600 hover:underline">
                        Fundamento Legal
                    </a> - Página 3
                </li>
                <li>
                    <a href="#conclusion" class="text-blue-600 hover:underline">
                        Conclusión
                    </a> - Página 4
                </li>
            </ul>
        </div>
    </div>

    <!-- Segunda Página - Responsabilidades -->
    <div id="responsabilidades-cargos" class="page break-after-page">
        <div class="px-8 py-12 bg-gray-50">
            <h2 class="text-4xl font-bold text-center text-blue-900">Responsabilidades de los Cargos</h2>
            @foreach ($cargos as $cargo)
                <div class="mt-8 p-4 bg-white rounded-md shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $cargo->nombre_cargo }}</h3>
                    <p class="mt-2 text-lg text-justify text-gray-700 leading-relaxed">{{ $cargo->descripcion_cargo }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tercera Página - Fundamento Legal -->
    <div id="fundamento-legal" class="page break-after-page">
        <div class="px-8 py-12 bg-gray-50">
            <h2 class="text-4xl font-bold text-center text-blue-900">Fundamento Legal</h2>
            <div class="mt-8 p-4 bg-white rounded-md shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800">Ley General de Educación (Ley 115 de 1994)</h3>
                <p class="mt-2 text-lg text-gray-700 leading-relaxed">
                    Regula la participación democrática en las instituciones educativas, promoviendo la formación
                    ciudadana de los estudiantes.
                </p>
            </div>
            <div class="mt-8 p-4 bg-white rounded-md shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800">Decreto 1860 de 1994</h3>
                <p class="mt-2 text-lg text-gray-700 leading-relaxed">
                    Establece los lineamientos para la elección de Personeros Estudiantiles, Representantes de Curso y
                    otros órganos de gobierno escolar.
                </p>
            </div>
        </div>
    </div>

    <!-- Página Final - Conclusión -->
    <div id="conclusion" class="page">
        <div class="flex flex-col items-center justify-center px-8 py-12 bg-gray-50">
            <h2 class="text-4xl font-bold text-center text-blue-900">Conclusión</h2>
            <p class="mt-6 text-lg text-justify max-w-3xl text-gray-700 leading-relaxed">
                La institución educativa <span class="font-semibold">{{ $nameInstitucion }}</span> agradece a toda la
                comunidad estudiantil por su activa participación en este proceso democrático, que fortalece la
                convivencia, la transparencia y el compromiso ciudadano.
            </p>
            <p class="mt-6 text-lg text-justify max-w-3xl text-gray-700 leading-relaxed">
                Seguiremos trabajando para garantizar que este tipo de actividades continúen siendo un espacio de
                aprendizaje y liderazgo, fomentando valores esenciales para nuestra sociedad.
            </p>
            <p class="mt-8 text-lg text-center font-semibold text-gray-600">
                {{ $nameInstitucion }} - {{ \Carbon\Carbon::now()->format('Y') }}
            </p>
        </div>
    </div>
</body>

</html>
