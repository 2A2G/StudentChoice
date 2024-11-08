<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class opcionesEstudiante extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
