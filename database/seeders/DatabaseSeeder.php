<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Empleado;
use App\Models\Departamentos;
use App\Models\Sucursales;
use App\Models\Asistencias;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Desactivar FKs y truncar en orden seguro
        Schema::disableForeignKeyConstraints();

        DB::table('asistencias')->truncate();
        DB::table('empleados')->truncate();
        DB::table('users')->truncate();
        DB::table('departamentos')->truncate();
        DB::table('sucursales')->truncate();

        Schema::enableForeignKeyConstraints();

        // 2) SUCURSALES
        $now = Carbon::now();
        Sucursales::insert([
            ['id' => 1, 'nombre' => 'Central',   'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'nombre' => 'Malasia',   'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'nombre' => 'Recogidas', 'estado' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'nombre' => 'Nevada',    'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'nombre' => 'Zaidín',    'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 3) DEPARTAMENTOS
        Departamentos::insert([
            ['id' => 1,  'nombre' => 'Administración', 'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2,  'nombre' => 'Logística',       'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3,  'nombre' => 'Cocina',          'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4,  'nombre' => 'Sala',            'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5,  'nombre' => 'Bar',             'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6,  'nombre' => 'Terraza',         'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7,  'nombre' => 'Limpieza',        'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8,  'nombre' => 'Recepción',       'estado' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9,  'nombre' => 'Marketing',       'estado' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'nombre' => 'Cocktail',        'estado' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4) USERS
        User::create([
            'name'        => 'Administrador Principal',
            'email'       => 'admin1@gmail.com',
            'password'    => Hash::make('12345678'),
            'rol'         => 'Administrador',
            'id_sucursal' => 1,
        ]);

        User::create([
            'name'        => 'Gestor Central',
            'email'       => 'gestor@central.com',
            'password'    => Hash::make('12345678'),
            'rol'         => 'Encargado',
            'id_sucursal' => 1,
        ]);

        User::create([
            'name'        => 'Gestor Nevada',
            'email'       => 'gestor@nevada.com',
            'password'    => Hash::make('12345678'),
            'rol'         => 'Encargado',
            'id_sucursal' => 4,
        ]);

        // 5) EMPLEADOS
        $empleados = [
            [
                'id' => 1,
                'nombre' => 'José Pérez Cava',
                'id_sucursal' => 1,
                'id_departamento' => 1,
                'email' => 'pepe@gmail.es',
                'dni' => '1111',
                'telefono' => '1313221',
                'estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'nombre' => 'Juan Domínguez Rosa',
                'id_sucursal' => 4,
                'id_departamento' => 5,
                'email' => 'juan@juam.es',
                'dni' => '2222',
                'telefono' => '77889999999',
                'estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'nombre' => 'Lucía Rodríguez Saavedra',
                'id_sucursal' => 5,
                'id_departamento' => 6,
                'email' => 'lucy@lazy.es',
                'dni' => '3333',
                'telefono' => '9999',
                'estado' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'nombre' => 'Antonio Moya Moya',
                'id_sucursal' => 5,
                'id_departamento' => 7,
                'email' => 'antonio@gmail.com',
                'dni' => '4444',
                'telefono' => '66223364',
                'estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'nombre' => 'Tony García López',
                'id_sucursal' => 4,
                'id_departamento' => 6,
                'email' => 'toni@toni.es',
                'dni' => '5555',
                'telefono' => '666',
                'estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        Empleado::insert($empleados);

        // 6) 20 ASISTENCIAS (todas cerradas: con entrada y salida)
        $fmt = 'Y-m-d H:i:s';
        $asistencias = [];

        // Helper: crea entrada/salida para un día relativo
        $mk = function (Carbon $base, int $daysAgo, string $in, string $out) use ($fmt) {
            $entrada = $base->copy()->subDays($daysAgo)->setTimeFromTimeString($in)->format($fmt);
            $salida  = $base->copy()->subDays($daysAgo)->setTimeFromTimeString($out)->format($fmt);
            return [$entrada, $salida];
        };

        // Generamos 4 asistencias cerradas por empleado (5 empleados * 4 = 20)
        for ($emp = 1; $emp <= 5; $emp++) {
            $e = collect($empleados)->firstWhere('id', $emp);
            $sid = $e['id_sucursal'];
            $did = $e['id_departamento'];

            // Creamos 4 días distintos por empleado
            [$e1, $s1] = $mk($now, 1 + $emp, '09:00:00', '17:00:00');
            [$e2, $s2] = $mk($now, 3 + $emp, '10:00:00', '18:00:00');
            [$e3, $s3] = $mk($now, 5 + $emp, '08:45:00', '16:30:00');
            [$e4, $s4] = $mk($now, 7 + $emp, '09:30:00', '17:15:00');

            $asistencias[] = [
                'id_empleado'     => $emp,
                'id_sucursal'     => $sid,
                'id_departamento' => $did,
                'entrada'         => $e1,
                'salida'          => $s1,
                'estado'          => 2, // cerrada
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
            $asistencias[] = [
                'id_empleado'     => $emp,
                'id_sucursal'     => $sid,
                'id_departamento' => $did,
                'entrada'         => $e2,
                'salida'          => $s2,
                'estado'          => 2,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
            $asistencias[] = [
                'id_empleado'     => $emp,
                'id_sucursal'     => $sid,
                'id_departamento' => $did,
                'entrada'         => $e3,
                'salida'          => $s3,
                'estado'          => 2,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
            $asistencias[] = [
                'id_empleado'     => $emp,
                'id_sucursal'     => $sid,
                'id_departamento' => $did,
                'entrada'         => $e4,
                'salida'          => $s4,
                'estado'          => 2,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
        }

        Asistencias::insert($asistencias);
    }
}
