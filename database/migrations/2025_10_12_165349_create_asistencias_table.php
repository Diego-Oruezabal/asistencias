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
        Schema::create('asistencias', function (Blueprint $table) {
             $table->id();

            $table->foreignId('id_empleado')->constrained('empleados')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_sucursal')->constrained('sucursales')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('id_departamento')->constrained('departamentos')->cascadeOnUpdate()->restrictOnDelete();

            // Mantener como TEXT
            $table->text('entrada')->nullable();
            $table->text('salida')->nullable();

            $table->tinyInteger('estado')->default(1); // 1=abierta, 2=cerrada (ajústalo si quieres)
            $table->timestamps();

            // Índices: solo por empleado (entrada TEXT no se puede indexar sin prefijo)
            $table->index('id_empleado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
