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

    public function opcionEstudiante()
    {
        return $this->hasMany(opcionesEstudiante::class);
    }
    public function postulante()
    {
        return $this->hasMany(postulante::class);
    }

    public function scopeComicio($query, $filters)
    {
        return $query
            ->with('postulante')
            ->withCount('postulante')
            ->when($filters['nombre_eleccion'] ?? null, function ($query, $nombreEleccion) {
                $query->where('nombre_eleccion', 'LIKE', "%{$nombreEleccion}%");
            })
            ->when($filters['estado'] ?? null, function ($query, $estado) {
                if ($estado == 'Eliminado') {
                    $query->onlyTrashed();
                } elseif ($estado == 'Activo') {
                    $query->whereNull('deleted_at');
                }
            });
    }
}
