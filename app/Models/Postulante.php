<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Postulante extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'cargo_id',
        'comicio_id',
        'cantidad_votos',
        'fotografia_postulante',
        'anio_postulacion',
    ];

    public function comicio()
    {
        return $this->belongsTo(Comicio::class, 'comicio_id');
    }

    public function postulanteCurso()
    {
        return $this->hasMany(PostulanteCurso::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function opcionesEstudiante()
    {
        return $this->hasMany(OpcionesEstudiante::class);
    }

    public function votos()
    {
        return $this->hasMany(Votos::class);
    }

    public function scopePostulante($query, $filters)
    {
        if (!empty($filters['numero_identidad'])) {
            $query->whereHas('estudiante', function ($query) use ($filters) {
                $query->where('numero_identidad', 'like', '%' . $filters['numero_identidad'] . '%');
            });
        }

        if (!empty($filters['curso_postulante'])) {
            $query->whereHas('curso', function ($query) use ($filters) {
                $query->where('id', $filters['curso_postulante']);
            });
        }

        if (!empty($filters['cargo'])) {
            $query->whereHas('cargo', function ($query) use ($filters) {
                $query->where('id', $filters['cargo']);
            });
        }

        if (!empty($filters['eleccion'])) {
            $query->whereHas('comicio', function ($query) use ($filters) {
                $query->where('id', $filters['eleccion']);
            });
        }

        if (!empty($filters['estado'])) {
            if ($filters['estado'] == 'Activo') {
                $query->whereNull('deleted_at');
            } elseif ($filters['estado'] == 'Eliminado') {
                $query->whereNotNull('deleted_at');
            }
        }


        return $query;
    }
}
