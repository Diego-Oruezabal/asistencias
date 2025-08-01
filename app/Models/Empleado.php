<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'id_sucursal',
        'id_departamento',
        'email',
        'dni',
        'telefono',
        'estado',
    ];

    public $timestamps = false;

    public function SUCURSAL()
    {
        return $this->belongsTo(Sucursales::class, 'id_sucursal');
    }

    public function DEPARTAMENTO()
    {
        return $this->belongsTo(Departamentos::class, 'id_departamento');
    }
}
