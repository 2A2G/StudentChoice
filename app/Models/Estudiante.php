<?php

namespace App\Models;

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

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

}
