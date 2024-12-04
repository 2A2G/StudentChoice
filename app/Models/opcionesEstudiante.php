<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class opcionesEstudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'cargo_id',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
