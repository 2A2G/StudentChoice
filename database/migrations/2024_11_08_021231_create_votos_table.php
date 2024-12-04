<?php

use App\Models\Cargo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->nullable();
            $table->foreignId('cargo_id');
            $table->integer('votos_en_blanco')->default(0);
            $table->integer('cantidad_voto')->default(0);

            $table->foreign('postulante_id')->references('id')->on('postulantes')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos');
    }
};
