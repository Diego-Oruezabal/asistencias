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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('id_sucursal')->constrained('sucursales')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('id_departamento')->constrained('departamentos')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('email')->unique();
            $table->string('dni')->index();
            $table->string('telefono')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
