<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;
    protected $table = 'habitacion';
    protected $primaryKey = 'id_habitacion';

    protected $fillable = [
        'num_habi',
        'id_ubicacion',
        'estado',
        'Precio_estadia_mensual',
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
