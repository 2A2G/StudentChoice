<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre_curso'
    ];

    public function postulanteCurso()
    {
        return $this->hasMany(PostulanteCurso::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'curso_id');
    }

    public function postulante()
    {
        return $this->hasMany(Postulante::class);
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $query->leftJoin('estudiantes', 'cursos.id', '=', 'estudiantes.curso_id')
            ->select(
                'cursos.id',
                'cursos.nombre_curso',
                DB::raw('SUM(CASE WHEN estudiantes.sexo = \'Masculino\' THEN 1 ELSE 0 END) as cantidad_estudiantes_masculinos'),
                DB::raw('SUM(CASE WHEN estudiantes.sexo = \'Femenino\' THEN 1 ELSE 0 END) as cantidad_estudiantes_femeninos'),
                DB::raw('COUNT(estudiantes.id) as cantidad_estudiantes'),
                DB::raw('CASE WHEN cursos.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            )
            ->when($filters['nombre_curso'] ?? null, function ($query, $nombre_curso) {
                $query->where('cursos.nombre_curso', 'like', "%$nombre_curso%");
            })
            ->when($filters['sexo'] ?? null, function ($query, $sexo) {
                $query->where('estudiantes.sexo', $sexo);
            })
            ->when($filters['estado'] ?? null, function ($query, $estado) {
                if ($estado == 'Eliminado') {
                    $query->onlyTrashed();
                } elseif ($estado == 'Activo') {
                    $query->whereNull('cursos.deleted_at');
                }
            })
            ->groupBy('cursos.id', 'cursos.nombre_curso', 'cursos.deleted_at')
            ->orderBy('cursos.id');
    }
}
