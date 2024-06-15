<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombreCargo',
        'descripcionCargo',
    ];

    public function postulantes()
    {
        return $this->hasMany(Postulante::class);
    }

}
