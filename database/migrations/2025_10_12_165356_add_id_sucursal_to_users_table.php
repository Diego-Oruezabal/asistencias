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
       Schema::table('users', function (Blueprint $table) {
            //  usuario debe pertenecer a una sucursal:
            $table->foreignId('id_sucursal')
                  ->nullable()
                  ->after('id')
                  ->constrained('sucursales')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();


        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'id_sucursal')) {
                $table->dropConstrainedForeignId('id_sucursal');
            }

        });
    }
};
