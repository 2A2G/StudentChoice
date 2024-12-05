<div>
    <x-guest-layout>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="mt-12 ml-4">
                @switch($caso)
                    @case('estudiante')
                        @livewire('invitado.estudiante')
                    @break

                    @case('votacion')
                        @livewire('invitado.votacion', ['cursoVotar' => $cursoVotar])
                    @break

                    @default
                        @livewire('invitado.dashboard')
                @endswitch
            </div>
        </div>
    </x-guest-layout>
</div>
