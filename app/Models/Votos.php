<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votos extends Model
{
    use HasFactory;
    protected $fillable = [
        'postulante_id',
        'cantidad_voto',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
