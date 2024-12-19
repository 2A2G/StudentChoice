<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comicio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre_eleccion'
    ];

    public static function getComicioActive()
    {
        $comicio = Comicio::where('estado', 'activo')->first();

        if (!$comicio) {
            throw new \Exception('No hay un comicio activo');
        }
        return $comicio->id;
    }

    public function opcionEstudiante()
    {
        return $this->hasMany(opcionesEstudiante::class);
    }
    public function postulante()
    {
        return $this->hasMany(postulante::class);
    }
}
