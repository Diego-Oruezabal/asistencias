<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $id_empleado
 * @property int $id_sucursal
 * @property int $id_departamento
 * @property string|null $entrada
 * @property string|null $salida
 * @property int $estado
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Empleado $EMPLEADO
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereEntrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereIdDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereIdEmpleado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereIdSucursal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencias whereUpdatedAt($value)
 */
	class Asistencias extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property int $estado
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamentos whereUpdatedAt($value)
 */
	class Departamentos extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property int $id_sucursal
 * @property int $id_departamento
 * @property string $email
 * @property string $dni
 * @property string|null $telefono
 * @property int $estado
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Departamentos $DEPARTAMENTO
 * @property-read \App\Models\Sucursales $SUCURSAL
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereIdDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereIdSucursal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Empleado whereUpdatedAt($value)
 */
	class Empleado extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property int $estado
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Empleado> $empleados
 * @property-read int|null $empleados_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sucursales whereUpdatedAt($value)
 */
	class Sucursales extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_sucursal
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $rol
 * @property-read \App\Models\Sucursales|null $SUCURSAL
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdSucursal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

