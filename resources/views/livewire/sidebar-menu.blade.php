<div>
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-800 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <div class="flex justify-center mb-6 bg-white p-4 rounded-full shadow-lg">
                            <x-authentication-card-logo class="w-32 h-32 md:w-40 md:h-40" />
                        </div>
                    </a>
                    <div
                        class="mt-6 flex flex-col justify-start items-center  pl-4 w-full border-gray-600 border-b space-y-3 pb-5 ">
                        @can('view dashboard')
                            <a href="{{ route('dashboard') }}"
                                :class="{
                                    'text-white bg-gray-700': request().routeIs('dashboard'),
                                    'text-gray-400': !request().routeIs(
                                        'dashboard')
                                }"
                                class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                <svg class="fill-stroke " width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#dc2626"
                                        d="M9 4H5C4.44772 4 4 4.44772 4 5V9C4 9.55228 4.44772 10 5 10H9C9.55228 10 10 9.55228 10 9V5C10 4.44772 9.55228 4 9 4Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path fill="#dc2626"
                                        d="M19 4H15C14.4477 4 14 4.44772 14 5V9C14 9.55228 14.4477 10 15 10H19C19.5523 10 20 9.55228 20 9V5C20 4.44772 19.5523 4 19 4Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path fill="#dc2626"
                                        d="M9 14H5C4.44772 14 4 14.4477 4 15V19C4 19.5523 4.44772 20 5 20H9C9.55228 20 10 19.5523 10 19V15C10 14.4477 9.55228 14 9 14Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path fill="#dc2626"
                                        d="M19 14H15C14.4477 14 14 14.4477 14 15V19C14 19.5523 14.4477 20 15 20H19C19.5523 20 20 19.5523 20 19V15C20 14.4477 19.5523 14 19 14Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <p class="text-base leading-4 ">Dashboard</p>
                            </a>
                        @endcan

                    </div>

                    {{-- Menu 1 --}}
                    <div class="flex flex-col justify-start items-center   px-6 border-b border-gray-600 w-full  ">
                        <button onclick="showMenu1(true)"
                            class="focus:outline-none focus:text-indigo-400 text-left  text-white flex justify-between items-center w-full py-5 space-x-14  ">
                            <p class="text-sm leading-5  uppercase">Gestión</p>
                            <svg id="icon1" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div id="menu1" class="flex justify-start  flex-col w-full md:w-auto items-start pb-1 ">
                            @can('view roles and permission')
                                <a href="{{ route('rolesPermisos') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="#dc2626" fill-rule="evenodd"
                                            d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2zM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2zM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2zM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-base leading-4  ">Roles y permisos</p>
                                </a>
                            @endcan
                            @can('view users')
                                <a href="{{ route('usuarios') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="#dc2626" stroke-linecap="round" stroke-width="2"
                                            d="M4.5 17H4a1 1 0 0 1-1-1a3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1a3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3a1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                    <p class="text-base leading-4  ">Usuarios</p>
                                </a>
                            @endcan
                            @can('view courses')
                                <a href="{{ route('viewCursos') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="#dc2626" fill-rule="evenodd"
                                            d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007c2.759-.038 4.5.16 6.956.791zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-base leading-4 ">Cursos</p>
                                </a>
                            @endcan
                            @can('view teachers')
                                <a href="{{ route('viewDocentes') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="#dc2626" fill-rule="evenodd"
                                            d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1m1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-base leading-4 ">Docentes</p>
                                </a>
                            @endcan
                            @can('view students')
                                <a href="{{ route('viewEstudiantes') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2 w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="#dc2626" fill-rule="evenodd"
                                            d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm3 8a3 3 0 1 1 6 0a3 3 0 0 1-6 0m-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3a1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-base leading-4  ">Estudiantes</p>
                                </a>
                            @endcan
                        </div>
                    </div>

                    {{-- Menu 2 --}}
                    <div class="flex flex-col justify-start items-center   px-6 border-b border-gray-600 w-full  ">
                        <button onclick="showMenu2(true)"
                            class="focus:outline-none focus:text-indigo-400 text-left  text-white flex justify-between items-center w-full py-5 space-x-14  ">
                            <p class="text-sm leading-5  uppercase">Sistema de votación</p>
                            <svg id="icon1" class="transform" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div id="menu2" class="flex justify-start  flex-col w-full md:w-auto items-start pb-1 ">
                            @can('view positions')
                                <a href="{{ route('viewCargos') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2 w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="#dc2626" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m7.171 12.906l-2.153 6.411l2.672-.89l1.568 2.34l1.825-5.183m5.73-2.678l2.154 6.411l-2.673-.89l-1.568 2.34l-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.68 1.68 0 0 1 2.64 0a1.68 1.68 0 0 0 1.515.628a1.68 1.68 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.68 1.68 0 0 1 0 2.639a1.68 1.68 0 0 0-.628 1.515a1.68 1.68 0 0 1-1.866 1.866a1.68 1.68 0 0 0-1.516.628a1.68 1.68 0 0 1-2.639 0a1.68 1.68 0 0 0-1.515-.628a1.68 1.68 0 0 1-1.867-1.866a1.68 1.68 0 0 0-.627-1.515a1.68 1.68 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.68 1.68 0 0 1 9.165 4.3M14 9a2 2 0 1 1-4 0a2 2 0 0 1 4 0" />
                                    </svg>
                                    <p class="text-base leading-4">Cargos</p>
                                </a>
                            @endcan

                            @can('view voting panel')
                                <a href="{{ route('viewPanelVotacion') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="none" stroke="#dc2626" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v5m-3 0h6M4 11h16M5 15h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1" />
                                    </svg>
                                    <p class="text-base leading-4  ">Panel de votación</p>
                                </a>
                            @endcan
                            @can('view voting history')
                                <a href="{{ route('viewHistorialVotacion') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2  w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <g fill="#dc2626" fill-rule="evenodd" clip-rule="evenodd">
                                            <path
                                                d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6z" />
                                            <path
                                                d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7z" />
                                        </g>
                                    </svg>
                                    <p class="text-base leading-4  ">Elecciones</p>
                                </a>
                            @endcan
                            @can('view applicants')
                                <a href="{{ route('viewPostulacion') }}"
                                    class="flex justify-start items-center space-x-6 hover:text-white focus:bg-gray-700 focus:text-white hover:bg-gray-700 text-gray-400 rounded px-3 py-2 w-full md:w-52">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="#dc2626" fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12m11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-base leading-4">Postulación</p>
                                </a>
                            @endcan
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="space-y-2 font-medium">
                {{-- Perfil y Cerrar Sesión --}}
                <div class="p-4 flex items-center justify-between bg-gray-800 shadow-md">
                    <a class="flex items-center space-x-2" href="{{ route('profile.show') }}">
                        <div>
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="avatar"
                                class="w-8 h-8 rounded-full" />
                        </div>

                        <div class="flex flex-col items-start">
                            <p class="cursor-pointer text-sm leading-5 text-white">{{ Auth::user()->name }}</p>
                            <p class="cursor-pointer text-xs leading-3 text-gray-300">{{ Auth::user()->email }}</p>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" x-data id="logout-form">
                        @csrf
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" class="cursor-pointer">
                                <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 12H4m12 0l-4 4m4-4l-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                            </svg>
                        </button>
                    </form>
                </div>
            </ul>
        </div>
    </aside>
</div>

<script>
    let icon1 = document.getElementById("icon1");
    let menu1 = document.getElementById("menu1");
    let menu2 = document.getElementById("menu2");
    const showMenu1 = (flag) => {
        if (flag) {
            icon1.classList.toggle("rotate-180");
            menu1.classList.toggle("hidden");
        }
    };
    const showMenu2 = (flag) => {
        if (flag) {
            icon1.classList.toggle("rotate-180");
            menu2.classList.toggle("hidden");
        }
    };


    let Main = document.getElementById("Main");
    let open = document.getElementById("open");
    let close = document.getElementById("close");

    const showNav = (flag) => {
        if (flag) {
            Main.classList.toggle("-translate-x-full");
            Main.classList.toggle("translate-x-0");
            open.classList.toggle("hidden");
            close.classList.toggle("hidden");
        }
    };
</script>
