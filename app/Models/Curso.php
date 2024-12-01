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

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public static function getCursoData($page)
    {
        return self::withTrashed()
            ->leftJoin('estudiantes', 'cursos.id', '=', 'estudiantes.curso_id')
            ->select(
                'cursos.id',
                'cursos.nombre_curso',
                DB::raw('SUM(CASE WHEN estudiantes.sexo = \'Masculino\' THEN 1 ELSE 0 END) as cantidad_estudiantes_masculinos'),
                DB::raw('SUM(CASE WHEN estudiantes.sexo = \'Femenino\' THEN 1 ELSE 0 END) as cantidad_estudiantes_femeninos'),
                DB::raw('COUNT(estudiantes.id) as cantidad_estudiantes'),
                DB::raw('CASE WHEN cursos.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            )
            ->groupBy('cursos.id', 'cursos.nombre_curso', 'cursos.deleted_at')
            ->orderByRaw('cursos.id')
            ->simplePaginate($page);
    }

}
