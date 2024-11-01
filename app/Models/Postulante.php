<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postulante extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'estudiante_id',
        'cargo_id',
        'cantidad_votos',
        'fotografia_postulante',
        'anio_postulacion',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }


}
