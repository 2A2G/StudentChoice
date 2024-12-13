<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostulanteCurso extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'postulante_id',
        'curso_id'
    ];

    public function cursos()
    {
        return $this->belongsTo(Curso::class);
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

}
