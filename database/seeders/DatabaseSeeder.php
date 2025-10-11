<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Empleado;
use App\Models\Departamentos;
use App\Models\Sucursales;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crea un usuario administrador
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Administrador',
            'id_sucursal' => 1, // Sucursal Central por defecto
        ]);

        // Crear 5 empleados
        Empleado::create([
            'nombre' => 'José Pérez Cava',
            'id_sucursal' => 1,
            'id_departamento' => 1,
            'email' => 'pepe@gmail.es',
            'dni' => '1313',
            'telefono' => '1313221',
            'estado' => 1,
        ]);

        Empleado::create([
            'nombre' => 'Juan Domínguez Rosa',
            'id_sucursal' => 4,
            'id_departamento' => 5,
            'email' => 'juan@juam.es',
            'dni' => '5656',
            'telefono' => '77889999999',
            'estado' => 1,
        ]);

        Empleado::create([
            'nombre' => 'Lucía Rodríguez Saavedra',
            'id_sucursal' => 5,
            'id_departamento' => 6,
            'email' => 'lucy@lazy.es',
            'dni' => '88888',
            'telefono' => '9999',
            'estado' => 0,
        ]);

        Empleado::create([
            'nombre' => 'Antonio Moya Moya',
            'id_sucursal' => 5,
            'id_departamento' => 7,
            'email' => 'antonio@gmail.com',
            'dni' => '4444',
            'telefono' => '66223364',
            'estado' => 1,
        ]);

        Empleado::create([
            'nombre' => 'Tony García López',
            'id_sucursal' => 4,
            'id_departamento' => 6,
            'email' => 'toni@toni.es',
            'dni' => '7777',
            'telefono' => '666',
            'estado' => 1,
        ]);

        //Crear departamentos
        $departamentos = [
            ['id' => 1,  'nombre' => 'Administración', 'estado' => 1],
            ['id' => 5,  'nombre' => 'Logistica',       'estado' => 1],
            ['id' => 6,  'nombre' => 'Cocina',          'estado' => 1],
            ['id' => 7,  'nombre' => 'Sala',            'estado' => 1],
            ['id' => 8,  'nombre' => 'Bar',             'estado' => 1],
            ['id' => 9,  'nombre' => 'Terraza',         'estado' => 1],
            ['id' => 10, 'nombre' => 'Limpieza',        'estado' => 1],
            ['id' => 11, 'nombre' => 'Recepción',       'estado' => 0],
            ['id' => 12, 'nombre' => 'Marketing',       'estado' => 0],
            ['id' => 13, 'nombre' => 'Cocktail',        'estado' => 1],
        ];

        foreach ($departamentos as $dep) {
            Departamentos::create($dep);
        }

        //Crear sucursales
        $sucursales = [
            ['id' => 1, 'nombre' => 'Central',   'estado' => 1],
            ['id' => 2, 'nombre' => 'Malasia',   'estado' => 1],
            ['id' => 3, 'nombre' => 'Recogidas', 'estado' => 0],
            ['id' => 4, 'nombre' => 'Nevada',    'estado' => 1],
        ];

        foreach ($sucursales as $sucursal) {
            Sucursales::create($sucursal);
        }

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
