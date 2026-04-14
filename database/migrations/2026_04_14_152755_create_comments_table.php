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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();

            $table->string('external_crm');
            $table->string('external_user_id');
            $table->string('ejecutivo_nombre');
            $table->string('equipo')->nullable();
            $table->string('supervisor')->nullable();

            $table->text('comentario');

            $table->string('etiqueta')->nullable();
            $table->string('tipo_contactabilidad')->nullable();
            $table->string('estado_etapa')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
