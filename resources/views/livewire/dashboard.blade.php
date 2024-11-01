<div>
    <x-app-layout>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="mt-12 ml-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @switch($caso)
                    {{-- Gestion --}}
                    @case('dashboard')
                        @livewire('super-admin.estadistica')
                    @break

                    @case('rolesPermisos')
                        @livewire('super-admin.roles')
                    @break

                    @case('usuarios')
                        @livewire('super-admin.usuarios')
                    @break

                    @case('cursos')
                        @livewire('super-admin.cursos')
                    @break

                    @case('docentes')
                        @livewire('super-admin.docentes')
                    @break

                    @case('estudiante')
                        @livewire('super-admin.estudiantes')
                    @break

                    <!--Sistema de Votación-->
                    @case('cargos')
                        @livewire('sistema-votacion.cargos')
                    @break

                    @case('panelVotacion')
                        @livewire('sistema-votacion.panel')
                    @break

                    @case('historialVotacion')
                        @livewire('sistema-votacion.historial')
                    @break

                    @case('postulacion')
                        @livewire('sistema-votacion.postulacion')
                    @break

                    @default
                        @livewire('super-admin.estadistica')
                @endswitch
                <x-footer />
            </div>
        </div>
    </x-app-layout>
</div>
