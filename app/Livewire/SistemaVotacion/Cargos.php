<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Cargo;
use Livewire\Attributes\On;
use Livewire\Component;

class Cargos extends Component
{

    public $open = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $nombre_cargo;
    public $descripcion_cargo;
    public $estado;
    public $cargo_id;

    public function clearInput()
    {
        $this->nombre_cargo = '';
        $this->descripcion_cargo = '';
    }

    public function cambiar()
    {
        $this->clearInput();
        $this->open = true;
    }

    public function store()
    {
        $this->validate(
            [
                'nombre_cargo' => 'required',
                'descripcion_cargo' => 'required'
            ]
        );

        Cargo::create(
            [
                'nombre_cargo' => $this->nombre_cargo,
                'descripcion_cargo' => $this->descripcion_cargo
            ]
        );

        $this->dispatch('post-created', name: "El cargo " . $this->nombre_cargo . ", creado satisfactoriamente");
        $this->clearInput();
        $this->open = false;
    }

    #[On('update-cargos')]
    public function edit($data)
    {
        $this->cargo_id = $data['id'];
        if ($data) {
            // dd($data);
            $this->nombre_cargo = $data['nombre_cargo'];
            $this->descripcion_cargo = $data['descripcion_cargo'];
            $this->estado = $data['estado'];
            $this->openUpdate = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del cargo, inténtelo nuevamente");
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'nombre_cargo' => 'required',
                'descripcion_cargo' => 'required'
            ]);

            $cargo = Cargo::withTrashed()->find($this->cargo_id)->first();

            // Verificar si el cargo existe
            if (!$cargo) {
                $this->openUpdate = false;
                $this->dispatch('post-error', name: "Error no se encontraron registros del cargo, inténtelo nuevamente");
                $this->clearInput();
            }

            if ($this->estado == 'Eliminado') {
                $cargo->delete();
            } else {
                $cargo->restore();
            }

            $cargo->update([
                'nombre_cargo' => $this->nombre_cargo,
                'descripcion_cargo' => $this->descripcion_cargo
            ]);


            $this->openUpdate = false;
            $this->dispatch('post-created', name: "El cargo " . $this->nombre_cargo . ", actualizado satisfactoriamente");
            $this->clearInput();

        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del cargo. Inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    #[On('delete-cargos')]
    public function preDelete($data)
    {
        if ($data) {
            $this->openDelete = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del cargo, inténtelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $cargo = Cargo::where('numero_identidad', $this->numero_identidad)->first();
            if (!$cargo) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del cargo, inténtelo nuevamente");
                $this->clearInput();
                return;
            }

            $cargo->delete();

            $this->dispatch('post-created', name: "El cargo ha sido eliminado satisfactoriamente");
            $this->openUpdate = false;

        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "El cargo " . $this->name . " no se pudo eliminar. Inténtelo nuevamente");
            throw $th;
        }
    }

    public function render()
    {
        $cargos = Cargo::count();
        return view(
            'livewire.sistema-votacion.cargos',
            [
                'cargos' => $cargos
            ]
        );
    }
}
