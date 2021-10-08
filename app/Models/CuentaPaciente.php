<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPaciente extends Model
{
    use HasFactory;
    protected $table = 'id_cuenta';
    protected $primaryKey = 'cuenta_paciente';

    protected $fillable = [
        'id_responsable',
        'saldo',
        'estado',
        'fecha_ingreso',
        'fecha_modificacion',
        'fecha_retiro'
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'fecha_retiro' => 'datetime',
    ];
}
