<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Comicio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre_eleccion',
        'estado_eleccion'
    ];

    public static function getComicioActive()
    {
        $comicio = Comicio::where('estado', 'activo')->first();

        if (!$comicio) {
            throw new \Exception('No hay un comicio activo');
        }
        return $comicio->id;
    }

    public static function getComicio($page)
    {
        return self::with('postulante')
            ->select('nombre_eleccion', 'id', 'estado', 'estado_eleccion', )
            ->withCount(['postulante as cantidad_postulantes'])
            ->simplePaginate($page);
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
