<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Docente extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'curso_id',
        'numero_identidad',
        'sexo',
        'asignatura'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public static function getDocenteData($page)
    {
        return self::withTrashed()
            ->leftJoin('cursos', 'docentes.curso_id', '=', 'cursos.id')
            ->leftJoin('users', 'docentes.user_id', '=', 'users.id')
            ->select(
                'docentes.id',
                'users.name',
                'users.email',
                'docentes.numero_identidad',
                'docentes.asignatura',
                'docentes.sexo',
                DB::raw('COALESCE(cursos.nombre_curso, \'No\') AS curso'),
                DB::raw('CASE WHEN docentes.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            )
            ->orderByRaw('docentes.id')
            ->simplePaginate($page);
    }
}
