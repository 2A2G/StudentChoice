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
        return $this->belongsTo(Comicio::class);
    }

    public function postulanteCurso()
    {
        return $this->hasMany(PostulanteCurso::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function opcionesEstudiante()
    {
        return $this->hasMany(OpcionesEstudiante::class);
    }

    public function votos()
    {
        return $this->hasMany(Votos::class);

    }

    public static function getPostulanteData($page)
    {
        return self::withTrashed()
            ->join('estudiantes', 'postulantes.estudiante_id', '=', 'estudiantes.id')
            ->join('cargos', 'postulantes.cargo_id', '=', 'cargos.id')
            ->join('cursos', 'estudiantes.curso_id', '=', 'cursos.id')

            ->select(
                'postulantes.id',
                DB::raw("CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellido_estudiante) as estudiante"),
                'cursos.nombre_curso as cursos',
                'cargos.nombre_cargo as cargos',
                DB::raw("CASE WHEN postulantes.deleted_at IS NULL THEN 'Activo' ELSE 'Eliminado' END as estado")
            )

            ->simplePaginate($page);
    }
}
