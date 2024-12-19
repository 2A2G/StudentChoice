<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postulantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id');
            $table->foreignId('curso_id');
            $table->foreignId('cargo_id');
            $table->string('fotografia_postulante');
            $table->string('anio_postulacion')->default(date('Y'));
            $table->foreignId('comicio_id');

            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
            $table->foreign('comicio_id')->references('id')->on('comicios');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulantes');
    }
};
