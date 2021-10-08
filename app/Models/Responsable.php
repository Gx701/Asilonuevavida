<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;
    protected $table = 'responsable';
    protected $primaryKey = 'id_responsable';

    protected $fillable = [
        'nombre_res_1',
        'nombre_res_2',
        'apellido_res_1',
        'apellido_res_2',
        'dpi_res',
        'nit_res',
        'fecha_nacimiento',
        'direccion',
        'telefono_res',
        'telefono_res2',
        'id_parentesco',
        'fecha_ingreso',
        'fecha_modificacion',
        'fecha_retiro',
        'foto_responsable',
        'estado'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'datetime',
        'fecha_ingreso' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_retiro' => 'datetime',
    ];

}
