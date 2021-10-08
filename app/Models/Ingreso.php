<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;
    protected $table = 'ingreso_asilo';
    protected $primaryKey = 'id_ingreso';

    protected $fillable = [
        'id_paciente',
        'id_habitacion',
        'fecha_ingreso',
        'fecha_modificacion',
        'fecha_retiro',
        'Total_Pagar',
        'id_usuario',  
        'estado'
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_retiro' => 'datetime',
    ];
}
