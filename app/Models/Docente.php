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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function scopeDocente($query, $filters)
    {
        if (!empty($filters['name_docente'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['name_docente']}%");
            });
        }

        if (!empty($filters['sexo'])) {
            $query->where('sexo', $filters['sexo']);
        }

        $query->when($filters['estado'] ?? null, function ($query, $estado) {
            if ($estado == 'Eliminado') {
                $query->onlyTrashed();
            } elseif ($estado == 'Activo') {
                $query->whereNull('deleted_at');
            }
        });

        if (!empty($filters['asignatura'])) {
            $query->where('asignatura', 'LIKE', "%{$filters['asignatura']}%");
        }

        if (!empty($filters['curso'])) {
            $curso = json_decode($filters['curso'], true);

            if (!empty($curso['nombre_curso'])) {
                $query->whereHas('curso', function ($q) use ($curso) {
                    $q->where('nombre_curso', 'LIKE', "%{$curso['nombre_curso']}%");
                });
            }
        }

        return $query;
    }
}
