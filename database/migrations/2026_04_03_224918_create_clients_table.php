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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->cascadeOnDelete();

            $table->string('identificacion_tipo')->nullable();
            $table->string('identificacion')->unique(); 

            $table->string('razon_social')->nullable();
            $table->string('nombre_comercial')->nullable();

            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombre_completo')->nullable();

            $table->string('direccion')->nullable();
            $table->string('departamento')->nullable();
            $table->string('provincia')->nullable();
            $table->string('distrito')->nullable();
            $table->string('ubigeo')->nullable();
            $table->string('ubigeo_id')->nullable();

            $table->string('estado')->nullable();
            $table->string('condicion')->nullable();
            $table->string('actividad_economica')->nullable();

            $table->string('ejecutivo')->nullable();
            $table->string('ejecutivo_identificacion')->nullable();
            $table->string('equipo')->nullable();
            $table->string('sede')->nullable();
            $table->string('supervisor')->nullable();

            $table->string('tipo_base')->nullable();

            $table->dateTime('fecha_gestion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
