<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
    protected $table = 'turno';
    protected $primaryKey = 'id_turno';

    protected $fillable = [
        'hora_inicio_m',
        'hora_salida_m',
        'hora_inicio_t',
        'hora_salida_t'
    ];

    protected $casts = [
        'hora_inicio_m' => 'datetime:H:i',
        'hora_salida_m' => 'datetime:H:i',
        'hora_inicio_t' => 'datetime:H:i',
        'hora_salida_t' => 'datetime:H:i',
    ];

    public function HorarioDetalles(){
        return $this->hasMany(HorarioDetalle::class);
    }
}
