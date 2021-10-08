<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'personal_administrativo';
    protected $primaryKey = 'id_empleado';


    protected $fillable = [
        'nombre_emp_1',
        'nombre_emp_2',
        'apellido_emp_1',
        'apellido_emp_2',
        'dpi_emp',
        'nit_emp',
        'fecha_nacimiento',
        'direccion',
        'telefono_emp',
        'telefono_emp2',
        'foto_emp',
        'fecha_ingreso',
        'fecha_modificacion',
        'fecha_retiro',
        'estado',
        'id_puesto'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'datetime',
        'fecha_ingreso' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_retiro' => 'datetime',
    ];
}
