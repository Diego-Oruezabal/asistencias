<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencias extends Model
{
     use HasFactory;
    protected $table = 'asistencias';
    protected $fillable = [
         'id_empleado',
         'id_sucursal',
         'id_departamento',
         'entrada',
         'salida',
         'estado',
    ];

    public $timestamps = false;
}
