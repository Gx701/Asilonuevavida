<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPacienteDetalle extends Model
{
    use HasFactory;
    protected $table = 'id_movimiento_cuenta';
    protected $primaryKey = 'movimiento_cuenta';

    protected $fillable = [
        'id_cuenta',
        'id_tipo_movimiento',
        'descripcion',
        'monto',
        'fecha_movimiento',
        'fecha_pago',
        'estado'
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
        'fecha_pago' => 'datetime',
    ];
    
}
