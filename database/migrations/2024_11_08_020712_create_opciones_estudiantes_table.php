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
        Schema::create('opciones_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id');
            $table->foreignId('cargo_id');
            $table->foreignId('comicio_id');

            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->foreign('comicio_id')->references('id')->on('comicios');

            $table->unique(['cargo_id', 'comicio_id']);

            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_estudiantes');
    }
};
