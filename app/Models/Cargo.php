<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cargo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre_cargo',
        'descripcion_cargo',
    ];

    const representanteCurso = 2;
    const contralor = 3;
    const personero = 1;


    public function postulantes()
    {
        return $this->hasMany(Postulante::class);
    }
    public function opcionesEstudiante()
    {
        return $this->hasMany(opcionesEstudiante::class);
    }

    public static function getCargoData($page)
    {
        return self::withTrashed()
            ->select(
                'id',
                'nombre_cargo',
                'descripcion_cargo',
                DB::raw('CASE WHEN deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            )->simplePaginate($page);
    }

}
