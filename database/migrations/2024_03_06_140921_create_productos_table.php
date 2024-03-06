<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Articulo');
            $table->string('Color');
            $table->unsignedBigInteger('Cant')->nullable(true)->default(null);
            $table->string('OBS');
            $table->string('Categoria');
            $table->boolean('es_Oferta')->default(false);
            $table->string('Imagen');
            $table->double('Precio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
