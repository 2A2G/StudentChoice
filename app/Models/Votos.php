<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votos extends Model
{
    use HasFactory;
    protected $fillable = [
        'postulante_id',
        'cargo_id',
        'cantidad_voto',
        'votos_en_blanco',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
