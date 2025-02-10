<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Cargo;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Cargos extends Component
{
    use WithPagination;

    public $open = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $nombre_cargo;
    public $descripcion_cargo;
    public $estado;
    public $cargo_id;
    public $numberCargo;
    public $numberCargoActive;


    public function mount()
    {
        $this->numberCargo = Cargo::withTrashed()->count();
        $this->numberCargoActive = Cargo::whereNull('deleted_at')->count();
    }
    public function clearInput()
    {
        $this->nombre_cargo = '';
        $this->descripcion_cargo = '';
        $this->mount();
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

    public function edit($data)
    {
        if ($data) {
            $this->cargo_id = $data['id'];
            $this->nombre_cargo = $data['nombre_cargo'];
            $this->descripcion_cargo = $data['descripcion_cargo'];
            $this->estado = $data['deleted_at'] ? 'Eliminado' : 'Activo';
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

            $cargo = Cargo::withTrashed()->where('id', $this->cargo_id)->first();
            // dd($cargo);

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

    public function preDelete($data)
    {
        if ($data) {
            $this->cargo_id = $data['id'];
            $this->openDelete = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del cargo, inténtelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $cargo = Cargo::find($this->cargo_id)->first();
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
        $query = Cargo::withTrashed();
        return view(
            'livewire.sistema-votacion.cargos',
            [
                'cargos' => $query->paginate(10)
            ]
        );
    }
}
