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
        Schema::create('postulante_cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id');
            $table->foreignId('curso_id');

            $table->foreign('postulante_id')->references('id')->on('postulantes');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulante_cursos');
    }
};
