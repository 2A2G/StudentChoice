<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_eleccion');
            $table->string('estado')->default('activo');
            $table->string('anio_eleccion')->default(date('Y'));
            $table->boolean('estado_eleccion')->default('false');

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('
            CREATE UNIQUE INDEX unique_active_comicio
            ON comicios (estado)
            WHERE estado = \'activo\';
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comicios');
    }
};
