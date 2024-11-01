<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

}
