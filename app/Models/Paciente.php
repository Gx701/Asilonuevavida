<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'paciente';
    protected $primaryKey = 'id_paciente';

    protected $fillable = [
        'nombre_pa_1',
        'nombre_pa_2',
        'apellido_pa_1',
        'apellido_ma_2',
        'dpi_pa',
        'nit_pa',
        'fecha_nacimiento',
        'direccion',
        'telefono_pa',
        'id_tipo_sangre',
        'sexo',
        'id_religion',
        'id_responsable',
        'fecha_ingreso',
        'fecha_modificacion',
        'fecha_retiro',
        'foto_paciente',
        'estado'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'datetime',
        'fecha_ingreso' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_retiro' => 'datetime',
    ];
}
