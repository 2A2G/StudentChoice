<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'numero_identidad',
        'nombre_estudiante',
        'apellido_estudiante',
        'sexo',
        'curso_id',
    ];

    const undecimo = 12;
    const decimo = 11;

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function postulantes()
    {
        return $this->hasMany(Postulante::class);
    }
    public function opcionesEstudiante()
    {
        return $this->hasMany(opcionesEstudiante::class);
    }

    public function scopeEstudiante($query, $filters)
    {
        if (!empty($filters['numero_identidad'])) {
            $query->where('numero_identidad', 'LIKE', "%{$filters['numero_identidad']}%");
        }

        if (!empty($filters['nombre_estudiante'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['nombre_estudiante']}%");
            });
        }

        if (!empty($filters['apellido_estudiante'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('last_name', 'LIKE', "%{$filters['apellido_estudiante']}%");
            });
        }

        if (!empty($filters['sexo'])) {
            $query->where('sexo', $filters['sexo']);
        }

        if (!empty($filters['estado'])) {
            if ($filters['estado'] == 'Activo') {
                $query->whereNull('deleted_at');
            } elseif ($filters['estado'] == 'Eliminado') {
                $query->whereNotNull('deleted_at');
            }
        }

        if (!empty($filters['curso_id'])) {
            $query->whereHas('curso', function ($q) use ($filters) {
                $q->where('id', $filters['curso_id']);
            });
        }

        return $query;
    }
}
