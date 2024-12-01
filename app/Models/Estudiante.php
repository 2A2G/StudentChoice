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

    public static function getEstudianteData($page)
    {
        return self::withTrashed()
            ->join('cursos', 'estudiantes.curso_id', '=', 'cursos.id')
            ->select(
                'estudiantes.id',
                'estudiantes.numero_identidad',
                'estudiantes.nombre_estudiante',
                'estudiantes.apellido_estudiante',
                'estudiantes.sexo',
                'cursos.nombre_curso as curso',
                DB::raw('CASE WHEN estudiantes.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            )
            ->orderByRaw('cursos.id')
            ->simplePaginate($page);
    }
}
