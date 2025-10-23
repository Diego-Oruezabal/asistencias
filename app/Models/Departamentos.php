<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    use HasFactory;
    protected $table = 'departamentos';
    protected $fillable = [
         'nombre',
         'estado',
    ];

    public $timestamps = false;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_departamento');
    }

}
